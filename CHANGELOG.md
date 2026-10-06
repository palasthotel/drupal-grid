# Changelog

## [3.0.0](https://github.com/palasthotel/drupal-grid/compare/v2.1.1...v3.0.0) (2026-10-06)


### ⚠ BREAKING CHANGES

* Sites whose grid module is older than update 8104 update to a 2.x release first.
* The module is installed with Composer, needs Drupal 10.3 or 11 and PHP 8.2. Add the repositories of palasthotel/drupal-grid and palasthotel/grid to the project's composer.json, require palasthotel/drupal-grid, build the editor in libraries/grid (npm ci && npm run build) and run the database updates. Back up the database

### Features

* embed Flickr albums with two-click consent ([77f1bd6](https://github.com/palasthotel/drupal-grid/commit/77f1bd6cb463f40473d8ffa7d92b52c24fd5a994))
* find nodes by id in the node box search ([53419f6](https://github.com/palasthotel/drupal-grid/commit/53419f646a3d8ff994755639784e51df21dbd5a5))
* get the grid library 3.0 through Composer ([1581f56](https://github.com/palasthotel/drupal-grid/commit/1581f56d59e84917068573270663fe9e5c4f44c1))
* hover mode, live indicator and autoplay for video boxes ([9968ed6](https://github.com/palasthotel/drupal-grid/commit/9968ed6d40d678d81bfda5fd71fbdb94769e199b))
* list view modes alphabetically ([84b4c94](https://github.com/palasthotel/drupal-grid/commit/84b4c94489ec0b790e5abf45a5613c31e45e6608))


### Bug Fixes

* cache a new YouTube lookup without warnings ([cddb139](https://github.com/palasthotel/drupal-grid/commit/cddb139f3e85c10c07637481611305831e8827ca))
* check a token and the usage before deleting reusable elements ([92afb1d](https://github.com/palasthotel/drupal-grid/commit/92afb1db4b4b2776577fb52ef9bfd833eea244eb))
* create the two-click table with its last_updated column ([6234e6e](https://github.com/palasthotel/drupal-grid/commit/6234e6ef2530588ea83725835833f151ae8595f8))
* **deps:** pin the grid library to the state before the video box moved here ([4921d2d](https://github.com/palasthotel/drupal-grid/commit/4921d2ddc6133d93ce6009f1d9605760ddaa95cd))
* **deps:** update jQuery UI to 1.14.2 ([727c7bb](https://github.com/palasthotel/drupal-grid/commit/727c7bba004cc6144a7335b722185574f1ac5acd))
* escape the playlist link of video boxes ([c3bb2a8](https://github.com/palasthotel/drupal-grid/commit/c3bb2a8a7793fec8638c41b8a6982c2f1868d49d))
* keep the grid working when a placed block is deleted ([bd30efc](https://github.com/palasthotel/drupal-grid/commit/bd30efc5b8f0f727414a406f4b0da8908f22baa3))
* keep two-click thumbnails for 30 days ([33bc4f2](https://github.com/palasthotel/drupal-grid/commit/33bc4f220e8e0d3787126990ef4669d5c1ea53a0))
* load the editors of reusable boxes and containers ([3d0da09](https://github.com/palasthotel/drupal-grid/commit/3d0da09dfefc87614becca3f5c5c0d3e95a8cf9e))
* load the HTML box ([34d4fb7](https://github.com/palasthotel/drupal-grid/commit/34d4fb7ffd23ddfecc170308be7988f39e6766c7))
* open node previews of grid pages again ([b10aea5](https://github.com/palasthotel/drupal-grid/commit/b10aea529a618fa44ea10593da9491b894f4e47c))
* open the grid editor and grid nodes again ([66c5c6a](https://github.com/palasthotel/drupal-grid/commit/66c5c6ab08560d418c087b3a1cf1dde5fb0638a7))
* recognize two-click providers by their exact host ([b19f9e3](https://github.com/palasthotel/drupal-grid/commit/b19f9e320ebe9d160faad05bf262d31617c2a4a2))
* require Drupal's CSRF token for the grid editor endpoints ([f71cb35](https://github.com/palasthotel/drupal-grid/commit/f71cb3531ac85dcbc58a014e08091588b8e435a1))
* reset only the page's layout container on the grid editor ([f791df3](https://github.com/palasthotel/drupal-grid/commit/f791df301babb25e354e6094ca8b559b6cb2791d))
* resolve the YouTube video id again ([55ad412](https://github.com/palasthotel/drupal-grid/commit/55ad412fa27a0b36776d7ce255ae0c1761c53cfd))
* return to the list after deleting a reusable container ([7ddb343](https://github.com/palasthotel/drupal-grid/commit/7ddb343723fa4256e2ed22db867570947f5832cb))
* run on Drupal 10 ([1753892](https://github.com/palasthotel/drupal-grid/commit/17538925a713acb6ebcd05083efec2f809a1c678))
* run the grid queries on Drupal's database connection ([e7a297c](https://github.com/palasthotel/drupal-grid/commit/e7a297ce1e501d2a9ca7010b9a653f4b6626ec8a))
* set up the two-click settings and their table ([6e03643](https://github.com/palasthotel/drupal-grid/commit/6e03643da6b483de2668ad9cb64f85076fc30176))
* show the thumbnail and the title setting of two-click video boxes ([705fb2e](https://github.com/palasthotel/drupal-grid/commit/705fb2e31a33a4e4d68c86ed86ee502cb73d7a68))
* **YouTubeAPI Fatal:** "Cannot access offset of type string on string" ([6014a70](https://github.com/palasthotel/drupal-grid/commit/6014a7038c546b6eb4c4f4ef9d6e866d430b4d86))


### Code Refactoring

* remove the updates of the 8.x-1.x line ([37345b6](https://github.com/palasthotel/drupal-grid/commit/37345b6769bb9b5fec33d5f8d26701afd9b2b1b6))

## Changelog
