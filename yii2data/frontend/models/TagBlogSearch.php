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
class TagBlogSearch extends \artsoft\post\models\Tag implements \vintage\search\interfaces\CustomSearchInterface
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
        return NULL;
    }

    /**
     * @inheritdoc
     */
    public function getSearchUrl()
    {
       return \yii\helpers\Url::toRoute(["/tag/{$this->slug}"]);
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
                ->joinWith('translations')->select(['post_tag_lang.title', 'post_tag.slug'])
                ->where(['like', 'post_tag_lang.title', $searchQuery]);
    }
}