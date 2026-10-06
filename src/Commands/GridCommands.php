<?php

namespace Drupal\grid\Commands;

use Drupal\grid\TwoClick\Constants\Constants;
use Drush\Commands\DrushCommands;

/**
 * A Drush commandfile.
 *
 * In addition to this file, you need a drush.services.yml
 * in root of your module, and a composer.json file that provides the name
 * of the services file to use.
 *
 * See these files for an example of injecting Drupal services:
 *   - http://cgit.drupalcode.org/devel/tree/src/Commands/DevelCommands.php
 *   - http://cgit.drupalcode.org/devel/tree/drush.services.yml
 */
class GridCommands extends DrushCommands {


  /**
   * @param $grid
   * @command grid:export
   */
  public function export($grid) {
    $grid_storage = grid_get_storage();
    $loaded_grid = $grid_storage->loadGrid($grid);
    $containers = $loaded_grid->container;
    foreach($containers as $container) {
      $container->grid = null;
      $container->storage=null;
      foreach($container->slots as $slot) {
        $slot->grid=null;
        $slot->storage=null;
        foreach($slot->boxes as $box) {
          $box->grid=null;
          $box->storage=null;
        }
      }
    }
    echo serialize($containers);
  }

  /**
   * @command grid:import
   */
  public function import() {
    $grid_storage = grid_get_storage();
    $content = file_get_contents("php://stdin");
    /** @var \Palasthotel\Grid\Model\Container[] $loaded */
    $loaded = unserialize($content);
    $grid_id = $grid_storage->createGrid();
    $grid = $grid_storage->loadGrid($grid_id);
    //we can't use the storage persisting options as those do something wrong...
    foreach($loaded as $container_to_import) {
      $type = $container_to_import->type;
      $imported_container = $grid_storage->createContainer($grid,$type);
      $grid->container[] = $imported_container;
      for($i=0;$i<count($imported_container->slots);$i++) {
        $imported_slot = $imported_container->slots[$i];
        $slot_to_import = $container_to_import->slots[$i];
        foreach($slot_to_import->boxes as $box) {
          $box->boxid=null;
          $box->grid=$grid;
          $box->storage=$grid_storage;
          $grid_storage->persistBox($box);
          $imported_slot->boxes[] = $box;
        }
        $grid_storage->storeSlotOrder($imported_slot);
      }
    }
    $grid_storage->storeContainerOrder($grid);
    echo $grid->gridid."\n";
  }

  /**
   * Clears all two-click-data
   *
   * @command grid:clearTwoClick
   */
  public function clearTwoClick()
  {
    $this->clearTwoClickThumbnails();
    $this->clearTwoClickDatabase();
  }

	/**
	 * @command grid:clearTwoClickThumbnails
	 */
	public function clearTwoClickThumbnails()
	{
		grid_delete_video_thumbnails();
    $this->logger()->success("Deleted thumbnails in ". Constants::THUMBNAIL_FOLDER_PATH);

  }

  /**
   * @command grid:clearTwoClickDB
   */
  public function clearTwoClickDatabase()
  {
    $database = \Drupal::database();
    $result = $database->delete(Constants::TWO_CLICK_DB_TABLE)->execute();
    $this->logger()->success("Database-table '" . Constants::TWO_CLICK_DB_TABLE . "' deleted!");
  }


}
