[![Unsupported](https://img.shields.io/badge/pantheon-unsupported-yellow?logo=pantheon&color=FFDC28)](https://pantheon.io/docs/oss-support-levels#unsupported)

Drupal module that extends [`smart_content`](https://www.drupal.org/project/smart_content) and [`segmentio`](https://www.drupal.org/project/segmentio) to support Pantheon Edge Integrations and personalization features and track winning personalization combinations.

Requirements
------------
SegmentIO User Account
Smart Content CDN

Configuration
-------------
* Visit the Segmentio configuration form. This module adds the following "Track" setting options:
1. Keywords (all referenced taxonomies) for the Page event.
2. Smart Content CDN personalization dimensions for the Identify event.
