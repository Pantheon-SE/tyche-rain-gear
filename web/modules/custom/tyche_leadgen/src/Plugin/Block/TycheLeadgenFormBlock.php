<?php

namespace Drupal\tyche_leadgen\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a "Example ajax submit form block".
 *
 * @Block(
 *   id = "tyche_leadgen_form_block",
 *   admin_label = @Translation("Tyche Leadgen Form"),
 *   category = @Translation("Martech")
 * )
 */
class TycheLeadgenFormBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('\Drupal\tyche_leadgen\Form\TycheLeadgenHubspotForm');

    return [
      '#theme' => 'tyche_leadgen_form',
      'form' => $form,
    ];
  }

}
