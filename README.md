CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Installation
 * Configuration

INTRODUCTION
------------

 Allows to store image assets from Bynder in a local image field, to display
 it using Drupal image styles.

 This module is in active development and not yet fully functional.

INSTALLATION
------------

 * `composer config repositories.bynder_local '{"type": "vcs", "url": "https://github.com/md-systems/bynder_local.git"}'`
 * `composer require md-systems/bynder_local`

CONFIGURATION
-------------

The module provides a "field_bynder_image" field storage. This field needs to be
added to all bynder media types that should store a local copy of the asset.

Then, on `/admin/config/services/bynder` verify the field configuration and
select an appropriate derivative to store as a local media. It is also possible
to download the original image through the download API, which is especially
useful when combined with SNS notifications for immediate updates.

Afterwards, configure the media entity to show an appropriate image style of
the "Bynder image" field instead of rendering the Bynder ID field.
