<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;
use himiklab\yii2\recaptcha\ReCaptchaValidator;
use common\components\behaviors\PurifyBehavior;

/**
 * This is the model class for table "{{%contact}}".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $body
 * @property int $subscribe
 * @property int $created_at
 */
class Contact extends ActiveRecord
{
    const SUBSCRIBE = 1;
    const UNSUBSCRIBE = 0;
    /**
     *
     * @var type 
     */
    public $verifyCode;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%contact}}';
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
            'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
            'purify' => [
                'class' => PurifyBehavior::className(),
                'attributes' => ['subject','body'],
                
            ],
        ];
    }
   
    /**
     * {@inheritdoc}
     */
   public function rules()
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required'],
            ['email', 'email'],
            [['name', 'subject'], 'string', 'min' => 5],
            ['body', 'string', 'min' => 30],
            ['subscribe', 'integer'],
            ['subscribe', 'default', 'value' => self::UNSUBSCRIBE],
            ['verifyCode', 'captcha'],
            ['created_at', 'safe'],
        ];
    }
/**
     * getSubscribeList
     * @return array
     */
    public static function getSubscribeList()
    {
        return array(
            self::SUBSCRIBE => Yii::t('art', 'Subscribe On'),
            self::UNSUBSCRIBE => Yii::t('art', 'Subscribe Off'),
        );
    }
    /**
     * getSubscribeValue
     *
     * @param string $val
     *
     * @return string
     */
    public static function getSubscribeValue($val)
    {
        $ar = self::getSubscribeList();

        return isset($ar[$val]) ? $ar[$val] : $val;
    }
    /**
     * {@inheritdoc}
     */
    
   public function attributeLabels() {
        return [
            'id' => Yii::t('art', 'ID'),
            'name' => Yii::t('art', 'Full Name'),
            'email' => Yii::t('art', 'E-mail'),
            'subject' => Yii::t('art', 'Title'),
            'body' => Yii::t('art', 'Content'),
            'created_at' => Yii::t('art', 'Created At'),
            'reCaptcha' => Yii::t('art', 'Captcha'),
            'subscribe' => Yii::t('art', 'Subscribe'),
            
        ];
    }
     /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose(
                Yii::$app->art->emailTemplates['send-contact'], 
                [
                    'body' => $this->body, 
                    'subject' => $this->subject
                ])
            ->setFrom([$this->email => $this->name])
            ->setTo($email)
            ->setSubject(Yii::t('art', 'Message for') . ' ' . Yii::$app->name)          
            ->send();
    }
    
    public function getCreatedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->created_at);
    }

    public function getCreatedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->created_at);
    }

    public function getCreatedDatetime()
    {
        return "{$this->createdDate} {$this->createdTime}";
    }
      public function getContent($content, $allowableTags = '<p>')
    {
        return strip_tags($content, $allowableTags);
    }
}
