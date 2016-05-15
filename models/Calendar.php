<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clndr_calendar".
 *
 * @property integer $id
 * @property string $text
 * @property integer $creator
 * @property string $date_event
 *
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clndr_calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'date_event'], 'required'],
            [['text'], 'string'],
            [['creator'], 'integer'],
            [['date_event'], 'safe'],
            [['creator'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator' => 'id']],
        ];
    }

    /**
     * Before save new note creator is current user
     * @param bool $insert
     * @return bool
     */
    public function beforeSave ($insert)
    {
        if ($this->getIsNewRecord())
        {
            $this->creator = Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Событие'),
            'creator' => Yii::t('app', 'Автор'),
            'date_event' => Yii::t('app', 'Дата и время события'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator']);
    }

    /**
     * Return dat in format for view
     *
     * @return mixed
     */
    public function getDateTimeEvent()
    {
        $date = new \DateTime($this->date_event);
        return $date->format('d/m/Y h:m:i');
    }

    /**
     * @inheritdoc
     * @return \app\models\query\CalendarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CalendarQuery(get_called_class());
    }
}
