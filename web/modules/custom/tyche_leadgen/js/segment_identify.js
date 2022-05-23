/**
 * @file
 * Segmentio Tracking Code.
 */

(function ($, Drupal, drupalSettings) {

  Drupal.behaviors.segment_identify = {
  
    attach(context, settings) {

      $.fn.hubspotSegmentIdentify = function(hubspotId) {
        var hsId = hubspotId;
        console.log(hsId);
        analytics.identify({ 'hubspotId': hsId });
      };
    }
  }

} (jQuery, Drupal, drupalSettings));
