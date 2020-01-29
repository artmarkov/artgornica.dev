<?php

namespace backend\modules\post\models;

use artsoft\behaviors\MultilingualBehavior;
use artsoft\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use artsoft\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use artsoft\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $slug
 * @property string $view
 * @property string $layout
 * @property integer $category_id
 * @property integer $status
 * @property integer $comment_status
 * @property string $thumbnail
 * @property integer $published_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $revision
 *
 * @property PostCategory $category
 * @property User $createdBy
 * @property User $updatedBy
 * @property PostLang[] $postLangs
 * @property Tag[] $tags
 */
class Post extends ActiveRecord 
{

    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;
    const COMMENT_STATUS_CLOSED = 0;
    const COMMENT_STATUS_OPEN = 1;
    const COUNT_POST_INDEX = 3;
    const MAIN_ON = 1;
    const MAIN_OFF = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }
     /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->isNewRecord && $this->className() == Post::className()) {
            $this->published_at = time();
        }     
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'in_attribute' => 'title',
                'out_attribute' => 'slug',
                'translit' => true           
            ],
            'multilingual' => [
                'class' => MultilingualBehavior::className(),
                'langForeignKey' => 'post_id',
                'tableName' => "{{%post_lang}}",
                'attributes' => [
                    'title', 'content',
                ]
            ],
            [
                'class' => \artsoft\behaviors\ManyHasManyBehavior::className(),
                'relations' => [
                    'tags' => 'tag_list',
                ],
            ],           
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['created_by', 'updated_by', 'status', 'comment_status', 'revision', 'category_id', 'main_flag'], 'integer'],
            [['title', 'content', 'view', 'layout'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['slug'], 'string', 'max' => 127],
            [['tag_list'], 'safe'],
            [['thumbnail'], 'string', 'max' => 255],
            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('art', 'ID'),
            'created_by' => Yii::t('art', 'Author'),
            'updated_by' => Yii::t('art', 'Updated By'),
            'slug' => Yii::t('art', 'Slug'),
            'view' => Yii::t('art', 'View'),
            'layout' => Yii::t('art', 'Layout'),
            'title' => Yii::t('art', 'Title'),
            'status' => Yii::t('art', 'Status'),
            'comment_status' => Yii::t('art', 'Comment Status'),
            'content' => Yii::t('art', 'Content'),
            'category_id' => Yii::t('art', 'Category'),
            'thumbnail' => Yii::t('art/post', 'Thumbnail'),
            'published_at' => Yii::t('art', 'Published'),
            'created_at' => Yii::t('art', 'Created'),
            'updated_at' => Yii::t('art', 'Updated'),
            'revision' => Yii::t('art', 'Revision'),
            'tag_list' => Yii::t('art/post', 'Tags'),
            'main_flag' => Yii::t('art', 'Main On'),
        ];
    }

    /**
     * @inheritdoc
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(\artsoft\post\models\Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(\artsoft\post\models\Tag::className(), ['id' => 'tag_id'])
                    ->viaTable('{{%post_tag_post}}', ['post_id' => 'id']);
    }


    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getPublishedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->published_at);
    }

    public function getCreatedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->created_at);
    }

    public function getUpdatedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->updated_at);
    }

    public function getPublishedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->published_at);
    }

    public function getCreatedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->created_at);
    }

    public function getUpdatedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->updated_at);
    }

    public function getPublishedDatetime()
    {
        return "{$this->publishedDate} {$this->publishedTime}";
    }

    public function getCreatedDatetime()
    {
        return "{$this->createdDate} {$this->createdTime}";
    }

    public function getUpdatedDatetime()
    {
        return "{$this->updatedDate} {$this->updatedTime}";
    }

    public function getStatusText()
    {
        return $this->getStatusList()[$this->status];
    }

    public function getCommentStatusText()
    {
        return $this->getCommentStatusList()[$this->comment_status];
    }

    public function getRevision()
    {
        return ($this->isNewRecord) ? 1 : $this->revision;
    }

    public function updateRevision()
    {
        $this->updateCounters(['revision' => 1]);
    }

    public function getAllContent($delimiter = '<p>', $allowableTags = '<a><blockquote><ul><ol><li>')
    {
         $result = '';
         $i = 0;
         $content = explode($delimiter, $this->content);
        
         foreach ($content as $id => $item) :
         
          $item =  strip_tags($item, $allowableTags);
         
             if(strlen($item) != 0) :          
                if($i == 0) { 
                    $result .= Html::tag('p', $item, ['class' => "dropcap"]);
                    $i++;
                }
                else {
                    $result .= Html::tag('p', $item);
                }
                
            endif;
         endforeach;
         
       return $result;        
    } 
    /**
     * 
     * @param type $length
     * @param type $allowableTags
     * @return type
     */
    public function getShortContent($length = 256, $allowableTags = '')
    {
        $content = strip_tags($this->content, $allowableTags);
        $result = mb_substr(Html::encode($content), 0, $length, "UTF-8") . ((strlen($content) > $length) ? ' ...' : '');
        return Html::tag('p', strip_tags($result, $allowableTags));
    }
    
    /**
     * getTypeList
     * @return array
     */
    public static function getMainList()
    {
        return [
            self::MAIN_ON => Yii::t('art', 'On'),
            self::MAIN_OFF => Yii::t('art', 'Off'),
        ];
    }
    /**
     * getStatusOptionsList
     * @return array
     */
    public static function getMainOptionsList()
    {
        return [
            [self::MAIN_ON, Yii::t('art', 'On'), 'primary'],
            [self::MAIN_OFF, Yii::t('art', 'Off'), 'default']
        ];
    }
    /**
     * getStatusOptionsList
     * @return array
     */
    public static function getStatusOptionsList()
    {
        return [
            [self::STATUS_PENDING, Yii::t('art', 'Pending'), 'default'],
            [self::STATUS_PUBLISHED, Yii::t('art', 'Published'), 'primary']
        ];
    }

    /**
     * getCommentStatusList
     * @return array
     */
    public static function getCommentStatusList()
    {
        return [
            self::COMMENT_STATUS_OPEN => Yii::t('art', 'Open'),
            self::COMMENT_STATUS_CLOSED => Yii::t('art', 'Closed')
        ];
    }
    /**
     * getTypeList
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_PENDING => Yii::t('art', 'Pending'),
            self::STATUS_PUBLISHED => Yii::t('art', 'Published'),
        ];
    }
    /**
     *
     * @inheritdoc
     */
    public static function getFullAccessPermission()
    {
        return 'fullPostAccess';
    }

    /**
     *
     * @inheritdoc
     */
    public static function getOwnerField()
    {
        return 'created_by';
    }
     /**
     *
     * @inheritdoc
     */
    public static function getCarouselOption()
    {
    return [
            'items' => 1,
            'single_item' => true,
            'navigation' => true,
            'pagination' => true,
            'transition_style' => 'fade',
            'auto_play' => '9000',           
            ];
    }
     /**
     * @return \yii\db\ActiveQuery
     */
    public static function getMediaInfo($id) {
        $model = Post::findOne($id);
        return [
            'name' => $model->title,
            'url' => 'post/update/' . $model->id,
        ];
    }

}
