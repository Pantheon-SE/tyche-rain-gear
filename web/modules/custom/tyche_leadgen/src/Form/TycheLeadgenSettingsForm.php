<?php

namespace Drupal\tyche_leadgen\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure site information settings for this site.
 */
class TycheLeadgenSettingsForm extends ConfigFormBase {

  /**
   * Constructs a \Drupal\tyche_leadgen\TycheLeadgenSettingsForm object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    parent::__construct($config_factory);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tyche_leadgen_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['tyche_leadgen.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = \Drupal::config('tyche_leadgen.settings');

    $form['hubspot_api_key'] = [
      '#type'          => 'textfield',
      '#title'         => $this->t('Hubspot API Key'),
      '#default_value' => $config->get('hubspot_api_key'),
      '#description'   => $this->t('Hubspot API key for demo purposes.
        Make sure to clear Drupal cache after you change API Key.'),
      '#required'      => TRUE,
    ];

    // $form['hubspot_bearer_token'] = [
    //   '#type'          => 'textfield',
    //   '#title'         => $this->t('Hubspot Bearer Token'),
    //   '#default_value' => $config->get('hubspot_bearer_token'),
    //   '#description'   => $this->t('Hubspot Bearer Token for demo purposes.'),
    //   '#required'      => TRUE,
    // ];

    $form['hubspot_url'] = [
      '#type'          => 'textfield',
      '#title'         => $this->t('Hubspot URL'),
      '#default_value' => $config->get('hubspot_url'),
      '#description'   => $this->t('Hubspot URL.'),
      '#required'      => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('tyche_leadgen.settings');

    // Enable/Disable plugin.
    $config->set('hubspot_api_key', $form_state->getValue('hubspot_api_key'))
      ->save();
    // $config->set('hubspot_bearer_token', $form_state->getValue('hubspot_bearer_token'))
    // ->save();
    $config->set('hubspot_url', $form_state->getValue('hubspot_url'))
      ->save();

    // Clear Drupal cache.
    \Drupal::cache()->delete('tyche_leadgen');

    parent::submitForm($form, $form_state);

  }

}
