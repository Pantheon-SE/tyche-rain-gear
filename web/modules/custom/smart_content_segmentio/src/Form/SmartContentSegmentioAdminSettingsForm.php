<?php

namespace Drupal\smart_content_segmentio\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Edit smart_content_segmentio Settings form.
 */
class SmartContentSegmentioAdminSettingsForm extends ConfigFormBase {

  use StringTranslationTrait;

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->moduleHandler = $container->get('module_handler');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'smart_content_segmentio_admin_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('smart_content_segmentio.settings')
      ->set('smart_content_segmentio_write_key', $form_state->getValue('smart_content_segmentio_write_key'))
      ->set('smart_content_segmentio_privacy', $form_state->getValue('smart_content_segmentio_privacy'))
      ->set('smart_content_segmentio_track', $form_state->getValue('smart_content_segmentio_track'))
      ->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'smart_content_segmentio.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('smart_content_segmentio.settings');

    $form['account'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Basic Settings'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];

    $form['account']['smart_content_segmentio_write_key'] = [
      '#title' => $this->t('Write Key'),
      '#type' => 'textfield',
      '#default_value' => $config->get('smart_content_segmentio_write_key'),
      '#size' => 200,
      '#maxlength' => 200,
      '#required' => TRUE,
      '#description' => t('This Write Key is unique to each Project you have configured in <a href="@smart_content_segmentio">Segment.io</a>. To get a Write Key, <a href="@analyticsjs">register your Project with Segment.io</a>, or if you already have registered your site, go to your Segment.io Project Settings page.analyticsjs will use this write key to send data to your project.', [
        '@smart_content_segmentio' => 'https://segment.io/login',
        '@analyticsjs' => 'https://segment.io/login',
      ]),
    ];

    // Advanced smart_content_segmentio configurations.
    $form['advanced'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Advance Configurations'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];

    // Privacy configurations.
    $form['advanced']['smart_content_segmentio_privacy'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Universal web tracking opt-out'),
      '#description' => $this->t('If enabled and your server receives the <a href="@donottrack">Do-Not-Track</a> header from the client browser, the smart_content_segmentio module will not embed any tracking code into your site. Compliance with Do Not Track could be purely voluntary, enforced by industry self-regulation, or mandated by state or federal law. Please accept your visitors privacy. If they have opt-out from tracking and advertising, you should accept their personal decision. This feature is currently limited to logged in users and disabled page caching.', [
        '@donottrack' => 'http://donottrack.us/',
      ]),
      '#default_value' => $config->get('smart_content_segmentio_privacy'),
    ];

    // Tracking settings.
    $form['advanced']['smart_content_segmentio_track'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Track Settings'),
      '#options' => $this->moduleHandler->invokeAll('smart_content_segmentio_info'),
      '#default_value' => $config->get('smart_content_segmentio_track'),
      '#description' => $this->t('Select which additional information should be tracked.'),
    ];

    return parent::buildForm($form, $form_state);
  }

}
