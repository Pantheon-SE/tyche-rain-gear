/**
 * @file
 * UTM and Segment UNITE.
 */

(function ($, Drupal) {

function whenAvailable(name, callback) {
    var interval = 10; // ms
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
  console.log('ayyy');
  if(params.has('hubspotId')) {
    let hsid = params.get('hubspotId');
    console.log(hsid);
    analytics.identify({ hubspotId: hsid });
  }
});

} (jQuery, Drupal));
