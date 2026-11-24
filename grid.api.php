<?php

/**
 * @file
 * Hooks provided by the Grid module.
 */

use Drupal\Core\Url;

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Adds a "put to trash" link to the list of reusable boxes.
 *
 * The list is at admin/config/grid/boxes. If at least one module implements
 * this hook, every box in the list gets a "put to trash" link next to "delete",
 * also if the box is still in use. The Grid module does not do anything with
 * the box itself: the target page is up to the implementing module, which has
 * to take care of access (for example administer grid) and, because the link is
 * a plain GET request, ask for a confirmation before it changes anything.
 *
 * The link needs a grid library that supports the trash link function of the
 * reusable box editor; with an older library it is not shown.
 *
 * @param int|string $id
 *   The id of the reusable box.
 *
 * @return \Drupal\Core\Url|null
 *   The url of the page that puts the box to the trash. The first url of all
 *   implementations is used.
 */
function hook_grid_reuse_box_trash_url($id) {
  return Url::fromRoute('mymodule.reusable_box.trash', ['id' => $id]);
}

/**
 * Adds a "put to trash" link to the list of reusable containers.
 *
 * Works like hook_grid_reuse_box_trash_url() for the list at
 * admin/config/grid/container.
 *
 * @param int|string $id
 *   The id of the reusable container.
 *
 * @return \Drupal\Core\Url|null
 *   The url of the page that puts the container to the trash.
 */
function hook_grid_reuse_container_trash_url($id) {
  return Url::fromRoute('mymodule.reusable_container.trash', ['id' => $id]);
}

/**
 * Alters the ids of the reusable boxes in the list.
 *
 * Called by the grid library, so the hook is available for the overview at
 * admin/config/grid/boxes.
 *
 * @param array $box_ids
 *   The ids of the reusable boxes that are listed.
 */
function hook_grid_reuse_box_ids_alter(array &$box_ids) {
  $box_ids = array_values(array_diff($box_ids, [42]));
}

/**
 * Alters the ids of the reusable containers in the list.
 *
 * Called by the grid library for the overview at admin/config/grid/container.
 *
 * @param array $container_ids
 *   The ids of the reusable containers that are listed.
 */
function hook_grid_reuse_container_ids_alter(array &$container_ids) {
  $container_ids = array_values(array_diff($container_ids, [42]));
}

/**
 * @} End of "addtogroup hooks".
 */
