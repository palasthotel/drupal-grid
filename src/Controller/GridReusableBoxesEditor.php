<?php
/**
 * Created by PhpStorm.
 * User: enno
 * Date: 19.08.15
 * Time: 13:33
 */

namespace Drupal\grid\Controller;


use Drupal\Core\Url;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Drupal\grid\Components\GridSafeString;
use Symfony\Component\HttpFoundation\RedirectResponse;

class GridReusableBoxesEditor
{
    public function boxesOverview()
    {
        $editor=grid_get_library()->editor->getReuseBoxEditor();
        $html=$editor->run(function($id){
            return Url::fromRoute("grid.admin.reusableboxes.editor",array('box'=>$id))->toString();
        },function($id){
            return Url::fromRoute("grid.admin.reusableboxes.delete",array('box'=>$id))->toString();
        },$this->trashLinkFunction());
        return array(
            '#attached'=>array(
                'library'=>array('grid/editor.reusableboxes'),
                'drupalSettings'=>grid_editor_settings(),
            ),
            '#cache'=>array('contexts'=>array('session')),
            '#type'=>'markup',
            '#markup'=>new GridSafeString($html),
        );
    }

    /**
     * The function that gives the "put to trash" url of a reusable box.
     *
     * @return callable|null
     *   NULL, if no module implements hook_grid_reuse_box_trash_url().
     */
    protected function trashLinkFunction()
    {
        $moduleHandler=\Drupal::moduleHandler();
        if(!$moduleHandler->hasImplementations('grid_reuse_box_trash_url'))
        {
            return null;
        }
        return function($id) use ($moduleHandler){
            foreach($moduleHandler->invokeAll('grid_reuse_box_trash_url',array($id)) as $url)
            {
                if($url instanceof Url)
                {
                    return $url->toString();
                }
            }
            return '';
        };
    }

    public function editor($box)
    {
        $editor=grid_get_library()->editor->getReuseBoxEditor();
        $html=$editor->runEditor(
            $box,
            Url::fromRoute('grid.editor.ckeditorjs')->toString(),
            Url::fromRoute('grid.editor.ajax')->toString(),
            \Drupal::config('grid.settings')->get('debug_mode'),
            Url::fromRoute('grid.admin.reusableboxes.preview',array('box'=>$box))->toString());
        return array(
            '#attached'=>array(
                'library'=>array('grid/editor.reusableboxes'),
                'drupalSettings'=>grid_editor_settings(),
            ),
            '#cache'=>array('contexts'=>array('session')),
            '#type'=>'markup',
            '#markup'=>new GridSafeString($html),
        );
    }

    public function preview($box)
    {
        $grid=grid_get_library()->api->loadGrid("box:".$box);
        return array(
            '#type'=>'markup',
            '#markup'=>new GridSafeString($grid->render(FALSE)),
        );
    }

    public function delete($box)
    {
        $storage=grid_get_storage();
        if(in_array((string)$box, array_map('strval', $storage->getReusedBoxIds()), TRUE))
        {
            throw new ConflictHttpException((string)t('This box is still in use.'));
        }
        $editor=grid_get_library()->editor->getReuseBoxEditor();
        $result=$editor->runDelete($storage,$box);
        if($result===TRUE)
        {
            return new RedirectResponse(Url::fromRoute('grid.admin.reusableboxes.overview')->toString());
        }
        return array(
            '#type'=>'markup',
            '#markup'=>new GridSafeString($result),
        );
    }
}
