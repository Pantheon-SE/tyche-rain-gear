/**
 * @file
 * UTM and Segment UNITE.
 */

(function ($, Drupal) {

function whenAvailable(name, callback) {
    var interval = 10; // ms to ensure Segmentio isloaded
    window.setTimeout(function() {
        if (window[name]) {
            callback(window[name]);
        } else {
            whenAvailable(name, callback);
        }
    }, interval);
}

whenAvailable("analytics", function(t) {
  const params = new URLSearchParams(window.location.search);
  if(params.has('__hsid')) {
    let hsid = params.get('__hsid');
    console.log(hsid);
    analytics.identify({ hubspotId: hsid });
  }
});

} (jQuery, Drupal));
