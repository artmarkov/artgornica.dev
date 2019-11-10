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
class PostBlogSearch extends \artsoft\post\models\Post implements \vintage\search\interfaces\CustomSearchInterface
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
        return $this->content;
    }

    /**
     * @inheritdoc
     */
    public function getSearchUrl()
    {
       return \yii\helpers\Url::toRoute(["/site/{$this->slug}"]);
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
                ->joinWith('translations')->select(['post_lang.title', 'post_lang.content', 'post.slug'])
                ->orWhere([
            'or',
            ['like', 'post_lang.title', $searchQuery],
            ['like', 'post_lang.content', $searchQuery],
        ]
          );
    }
    /**
     * Подсветка слова в тексте
     * 
     * @param type $text
     * @param type $word
     * @return type string
     */
    public static function getFragment($text, $word){
        if ($word)
        {
            $text = strip_tags($text);
            $pos = max(mb_stripos($text, $word, null, 'UTF-8') - 100, 0);
            $fragment = mb_substr($text, $pos, 200, 'UTF-8');
            $highlighted = str_ireplace($word, '<mark>' . $word . '</mark>', $fragment);
        } else {
            $highlighted = mb_substr($text, 0, 200, 'UTF-8');
        }
        return $highlighted;
    }
}