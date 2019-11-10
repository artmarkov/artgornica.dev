<?php

namespace frontend\widgets;

/*
 * Simple tag cloud widget
 * @author Yaroslav Pelesh aka Tokolist http://tokolist.com
 * @link https://github.com/tokolist/yii-components
 * @version 1.1
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */
use artsoft\helpers\Html;
use yii\helpers\ArrayHelper;

class TagCloudWidget extends \yii\base\Widget
{
        const DISTRIBUTION_LINEAR = 0;
	const DISTRIBUTION_LOGARITHMIC = 1;
	
	public $maxTags = 30;
	public $distribution = self::DISTRIBUTION_LOGARITHMIC;
	public $tagTableName = 'name';
	public $urlParamName = 'slug';
	public $tagTableCount = 'count';
	public $urlRoute = 'site/index';
	public $tagClasses = ['class_12', 'class_13', 'class_14', 'class_15'];
	public $linkOptions = ['nowrap'];
        public $iconClass = ['fa fa-tags'];
	public $itemTemplate = "{link}\n";
        public $tagsArray = [ 0 => ['id' => 1, 'name' => 'art-cms', 'slug' => 'art-cms',  'count' => 2] ];


        protected function getLinearDistribution($rows, $maxCount, $minCount, $classesCount)
	{
		$tags = array();
		$countDiff = $maxCount - $minCount;
                if($countDiff == 0) { $countDiff = 1; }
		$minCount--; $countDiff++; //Prevent zero division
		$classesCount--;
		foreach($rows as $row)
		{
			$tags[$row[$this->urlParamName]] = [ $this->tagTableName => $row[$this->tagTableName], 'class' =>$this->tagClasses[
				floor(($row[$this->tagTableCount] - $minCount) / $countDiff * $classesCount)
                            ]
			];
		}
		return $tags;
	}
	protected function getLogarithmicDistribution($rows, $maxCount, $minCount, $classesCount)
	{
		$tags = array();
		$minCount++;
		$maxCount++;
		$countDiff = log($maxCount) - log($minCount); 
                if($countDiff == 0) { $countDiff = 1;}
		$classesCount--;
		$minCount = log($minCount);
		foreach($rows as $row)
		{
			$tags[$row[$this->urlParamName]] = [ $this->tagTableName => $row[$this->tagTableName], 'class' => $this->tagClasses[
				floor((log($row[$this->tagTableCount] + 1) - $minCount) / $countDiff * $classesCount)
                            ]
			];
		}
		return $tags;
	}
	private function ciStringCompare($a, $b)
	{
		return strtolower($a) > strtolower($b);
	}
	public function run()
        {
         
           $this->maxTags != false ? $rows = array_slice($this->tagsArray, 0, $this->maxTags, true) : $rows = $this->tagsArray;
           
            usort($rows, function($a, $b) {
            if ($a['count'] === $b['count']){
                return 0;
            }
            return $a['count'] > $b['count'] ? -1 : 1;
        });
        
    //        $sql = "SELECT * FROM {$this->tagTable} ORDER BY {$this->tagTableCount} DESC";
    //		if($this->maxTags !== false) {
    //			$sql .= " LIMIT {$this->maxTags}";
    //                }
    //		$command = \Yii::$app->db->createCommand($sql);
    //		$rows = $command->queryAll();

                
		if(!empty($rows))
		{
			$minCount = $rows[count($rows) - 1][$this->tagTableCount];
			$maxCount = $rows[0][$this->tagTableCount];
			$classesCount = count($this->tagClasses);
			switch($this->distribution)
			{
				case self::DISTRIBUTION_LINEAR:
					$tags = $this->getLinearDistribution($rows, $maxCount, $minCount, $classesCount);
					break;
				default: //DISTRIBUTION_LOGARITHMIC
					$tags = $this->getLogarithmicDistribution($rows, $maxCount, $minCount, $classesCount);
					break;
			}
			ksort($tags, SORT_LOCALE_STRING);
			//uksort($tags, array($this, 'ciStringCompare'));
                       // echo '<pre>' . print_r($tags, true) . '</pre>';
			foreach($tags as $slug => $item)
			{
                           $link =  Html::a(Html::encode($item['name']), [$this->urlRoute, $this->urlParamName=>$slug], ['class' => ArrayHelper::merge($this->linkOptions, [$item['class']])]);
  			 
//                                $icon =  Html::tag('i', '', ['class' => ArrayHelper::merge($this->iconClass, [$item['class']]),'aria-hidden'=>'true']);//                                
//                                $link =  Html::a($icon . Html::encode($item['name']), [$this->urlRoute, $this->urlParamName=>$slug], ['class' => $this->linkOptions]);
                                
				echo strtr($this->itemTemplate, array('{link}'=>$link));
			}
		}
	}
}
