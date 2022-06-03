<?php

namespace Drupal\smart_content_segmentio\EventSubscriber;

use Drupal\smart_content\Decision\Storage\DecisionStorageManager;
use Drupal\smart_content\Event\AttachDecisionSettingsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

// /**
//  * Subscribes to attaching settings to decisions.
//  *
//  * @package Drupal\smart_content_segmentio\EventSubscriber
//  */
// class DecisionSettingsSubscriber implements EventSubscriberInterface {

//   /**
//    * The decision storage plugin manager.
//    *
//    * @var \Drupal\smart_content\Decision\Storage\DecisionStorageManager
//    */
//   protected $decisionStorageManager;

//   /**
//    * DecisionSettingsSubscriber constructor.
//    *
//    * @param \Drupal\smart_content\Decision\Storage\DecisionStorageManager $decisionStorageManager
//    *   The decision storage plugin manager service.
//    */
//   public function __construct(DecisionStorageManager $decisionStorageManager) {
//     $this->decisionStorageManager = $decisionStorageManager;
//   }

//   /**
//    * {@inheritDoc}
//    */
//   public static function getSubscribedEvents() {
//     return [
//       AttachDecisionSettingsEvent::EVENT_NAME => 'addCustomSettings',
//     ];
//   }

//   /**
//    * Event handler to attach custom settings to decisions.
//    *
//    * @param \Drupal\smart_content\Event\AttachDecisionSettingsEvent $event
//    *   The event object for the subscribed event.
//    *
//    * @throws \Drupal\Component\Plugin\Exception\PluginException
//    */
//   public function addCustomSettings(AttachDecisionSettingsEvent $event) {
//     $settings =& $event->getSettings();
//     $settings['smart_content'] = [];

//     $decisions = $settings['decisions'];
//     foreach ($decisions as $decision) {
//       // Load the correct decision storage plugin.
//       /** @var \Drupal\smart_content\Decision\Storage\DecisionStorageInterface $decision_storage */
//       $decision_storage = $this->decisionStorageManager->createInstance($decision['storage']);

//       // Make sure the entity is loaded.
//       $decision_storage->loadDecisionFromToken($decision['token']);
//       if ($decision_storage->hasDecision()) {
//         /** @var \Drupal\smart_content\Decision\DecisionInterface $decision_plugin */
//         $decision_plugin = $decision_storage->getDecision();

//         if ($decision_plugin) {
//           // Load the segments from the decision.
//           $segments = $decision_plugin->getSegmentSetStorage()->getSegmentSet()->getSegments();
//           foreach ($segments as $segment) {
//             $settings['smart_content'][$segment->getUuid()] = [
//               'label' => $segment->getLabel(),
//               'reactions' => [],
//             ];
//           }
//           // Get the reaction plugins and get each one's summary.
//           foreach ($decision_plugin->getReactions() as $reaction_id => $reaction) {
//             /** @var \Drupal\smart_content\Reaction\ReactionInterface $reaction */
//             $settings['smart_content'][$reaction_id]['reactions'][] = $reaction->getPlainTextSummary();
//           }
//         }
//       }
//     }
//   }

// }
