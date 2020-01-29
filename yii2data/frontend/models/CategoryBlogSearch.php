<?php
namespace frontend\models;
use yii\db\ActiveQueryInterface;
/**
 * Article search model.
 * 
 * @property integer $id
 * @property string $title
 * @property string $short_description
 * @property string $content
 */
class CategoryBlogSearch extends \artsoft\post\models\Category implements \vintage\search\interfaces\CustomSearchInterface
{
    /**
     * @inheritdoc
     */
    public function getSearchTitle()
    {
        return $this->title;
    }

    /**
     * @inheritdoc
     */
    public function getSearchDescription()
    {
        return $this->description;
    }

    /**
     * @inheritdoc
     */
    public function getSearchUrl()
    {
       return \yii\helpers\Url::toRoute(["/category/{$this->slug}"]);
    }

   /**
    * @inheritdoc
    */
    public function getSearchFields()
    {
        return [
            'slug',
        ];
    }
 
   /**
     * @inheritdoc
     */
    public function getQuery(ActiveQueryInterface $query, $field, $searchQuery)
    {
        return $query
                ->joinWith('translations')->select(['post_category_lang.title', 'post_category_lang.description', 'post_category.slug'])
                ->orWhere([
            'or',
            ['like', 'post_category_lang.title', $searchQuery],
            ['like', 'post_category_lang.description', $searchQuery],
        ]
          );
    }
}