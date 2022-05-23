<?php

namespace Drupal\tyche_leadgen\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\GuzzleHttp\Exception\RequestException;
use Drupal\Core\Url;
use GuzzleHttp\Psr7\Response;

/**
 * Implementing a ajax form.
 */
class TycheLeadgenHubspotForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tyche_leadgen_hubspot';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['#attached']['library'][] = 'tyche_leadgen/tyche_segment_leadgen';

    $form['email'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Email'),
    ];

    // $form['firstname'] = [
    //   '#type' => 'textfield',
    //   '#title' => $this->t('Given Name'),
    // ];

    // $form['lastname'] = [
    //   '#type' => 'textfield',
    //   '#title' => $this->t('Family Name'),
    // ];

    $form['actions'] = [
      '#type' => 'button',
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::setMessage',
      ],
    ];

    return $form;
  }

  /**
   * Setting the message in our form.
   */
  public function setMessage(array $form, FormStateInterface $form_state) {

    //$request_url = Url::fromUri('https://api.hubapi.com/crm/v3/objects/contacts');

    $form_data = [
      'properties' => [
        'email' => $form_state->getValue('email'),
        // 'firstname' => $form_state->getValue('firstname'),
        // 'lastname' => $form_state->getValue('lastname'),
      ],
    ];

    $data = $this->remotePost($form_data, 'hubspot');
    $response = new AjaxResponse();
    $response->addCommand(new InvokeCommand(NULL, 'hubspotSegmentIdentify', [$data['id']]));
    $response->addCommand(
      new HtmlCommand(
        '.leadgen_response',
        t('Thanks for signing up!')
      ),
    );
    return $response;
  }

  /**
   * Submitting the form.
   * We aren't saving anything right now: yolo.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * Execute a remote post.
   *
   * @param FormStateInterface $state
   *   The state of the block submission.
   */
  protected function remotePost($form_data, $leadgen) {

    $config = \Drupal::config('tyche_leadgen.settings');
    $api_key = $config->get($leadgen . '_api_key');
    //$bearer = $config->get($leadgen . '_bearer_token');
    $request_url = Url::fromUri($config->get($leadgen . '_url'), array('absolute' => TRUE))->toString();

    if (empty($api_key)) {
      return;
    }
    
    //'Authorization' => 'Bearer ' . $bearer,
    try {
        $request_options = [
          'query' => [
            'hapikey' => $api_key,
          ],
          'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
          ],
          'https' => TRUE,
          'json' => $form_data,
        ];

        $response = \Drupal::httpClient()->post($request_url, $request_options);

    } catch (RequestException $request_exception) {
      $response = $request_exception->getResponse();
      // TODO: logger
      return;
    }

    // Display submission exception if response code is not 2xx.
    if ($response->getStatusCode() !== 201) {
      // $response->getStatusCode()]);
      // TODO: logger
      return;
    }
    else {
      $response_data = $this->getResponseData($response);
      return($response_data);
    }
  }

  /**
   * Get response data.
   * @param \GuzzleHttp\Psr7\Response $response
   *   The response returned by the remote server.
   *
   * @return array|string
   *   An array of data, parse from JSON, or a string.
   */
  protected function getResponseData(Response $response) {
    $body = (string) $response->getBody();
    $data = json_decode($body, TRUE);
    return (json_last_error() === JSON_ERROR_NONE) ? $data : $body;
  }
}
