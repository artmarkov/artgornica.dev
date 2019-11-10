<?php

/** 
 * refactor renderItems \klisl\nestable\Nestable !!!
 * 
 * 
 * @copyright Copyright &copy; Arno Slatius 2015
 * @package yii2-nestable
 * Modified for yii2-Nested-Sets-Drag-and-drop - Copyright (c) 2018 Sergey Klimenchuk - http://klisl.com
 */

namespace backend\components;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Create nestable lists using drag & drop for Yii 2.0.
 * Based on jquery.nestable.js plugin.
 *
 * @author Arno Slatius <a.slatius@gmail.com>
 * @since 1.0
 */
class Nestable extends \klisl\nestable\Nestable
{
	
	protected function renderItems($_items = NULL) {


		$_items = is_null($_items) ? $this->items : $_items;
		$items = '';
        $dataid = 0;
		foreach ($_items as $item) {

			$options = ArrayHelper::getValue($item, 'options', ['class' => 'dd-item dd3-item']);
            $options = ArrayHelper::merge($this->itemOptions, $options);
            $dataId  = ArrayHelper::getValue($item, 'id', $dataid++);
            $options = ArrayHelper::merge($options, ['data-id' => $dataId]);

            $contentOptions = ArrayHelper::getValue($item, 'contentOptions', ['class' => 'dd3-content']);
			$content = $this->handleLabel;

            $id = $item['id']; //id item

            //create links (GridView) for viewing and manipulating the items.
//            $spanView = Html::tag('span', null, ['class' => "glyphicon glyphicon-eye-open"]);
//            $aView = Html::tag('a', $spanView . '&nbsp; ', ['title' => 'View', 'aria-label' => 'View', 'data-pjax' => '0', 'href'=> $this->viewItem .'?id=' . $id]);
            $spanUpdate = Html::tag('span', null, ['class' => "glyphicon glyphicon-pencil"]);
            $aUpdate = Html::tag('a', $spanUpdate . '&nbsp; ', ['title' => 'Update', 'aria-label' => 'Update', 'data-pjax' => '0', 'href'=> $this->update .'?id=' . $id]);
            $spanDelete = Html::tag('span', null, ['class' => "glyphicon glyphicon-trash"]);
            $aDelete = Html::tag('a', $spanDelete . '&nbsp; ', ['title' => 'Delete', 'aria-label' => 'Delete', 'data-pjax' => '0', 'data-confirm' => 'Are you sure you want to delete this item?', 'data-method' => 'post', 'href'=> $this->delete .'?id=' . $id]);

            $links = Html::tag('div', $aUpdate . $aDelete, ['class' => "actionColumn"]);
            $item['content'] .= $links;


			$content .= Html::tag('div', ArrayHelper::getValue($item, 'content', ''), $contentOptions);

			$children = ArrayHelper::getValue($item, 'children', []);
			if (!empty($children)) {
					// recursive rendering children items
				$content .= Html::beginTag('ol', ['class' => 'dd-list']);
				$content .= $this->renderItems($children);
				$content .= Html::endTag('ol');
			}

			$items .= Html::tag('li', $content, $options) . PHP_EOL;
		}
		return $items;
	}

	
}
