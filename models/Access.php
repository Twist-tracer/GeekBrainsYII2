<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "clndr_access".
 *
 * @property integer $id
 * @property integer $user_owner
 * @property integer $user_guest
 * @property string $date
 *
 * @property User $userOwner
 * @property User $userGuest
 */
class Access extends \yii\db\ActiveRecord
{

    const ACCESS_CREATOR = 1;
    const ACCESS_GUEST = 2;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clndr_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_guest', 'date'], 'required'],
            [['user_guest'], 'integer'],
            [['date'], 'safe'],
            [['user_guest'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_guest' => 'id']],
        ];
    }

    /**
     * Before save new access owner is current user
     * @param bool $insert
     * @return bool
     */
    public function beforeSave ($insert)
    {
        if ($this->getIsNewRecord())
        {
            $this->user_owner = Yii::$app->user->id;
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
            'user_owner' => Yii::t('app', 'Владелец'),
            'user_guest' => Yii::t('app', 'Гость'),
            'date' => Yii::t('app', 'Дата'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'user_owner']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserGuest()
    {
        return $this->hasOne(User::className(), ['id' => 'user_guest']);
    }

    /**
     * @return array $users 
     */
    public function getAllUsers()
    {
        $result = User::find()
            ->asArray()
            ->select([
                'id',
                'CONCAT(`name`, \' \', `surname`, \' (\', `username` , \')\') as name'
            ])
            ->where('id != :id', ['id' => Yii::$app->user->id])
            ->all();

        $users = array();

        foreach ($result as $user) {
            $users[$user['id']] = $user["name"];
        }

        return $users;
    }

    /**
     * @return array $sharedDates
     */
    public function getAllSharedDates()
    {
        $sharedDates = $this::find()
            ->asArray()
            ->select(['date as label', 'group_concat(CONCAT(`name`, \' \', `surname`, \' (\', `username` , \')\')) as content'])
            ->where('user_owner = :id', ['id' => Yii::$app->user->id])
            ->leftJoin('clndr_user', 'clndr_user.id = user_guest')
            ->groupBy('date')
            ->orderBy('date')
            ->all();

        $i = 0;
        while ($i < count($sharedDates)) {
            $sharedDates[$i]['content'] = explode(',', $sharedDates[$i]['content']);
            $i++;
        }
        
        return $sharedDates;
    }

    /**
     * @return array $friendsEvents
     */
    public function getAllFriendsEvents()
    {
        $friendsEvents = $this::find()
            ->asArray()
            ->select(['clndr_user.id', 'CONCAT(`name`, \' \', `surname`, \' (\', `username` , \')\') as label', 'group_concat(date) as content'])
            ->where('user_guest = :id', ['id' => Yii::$app->user->id])
            ->leftJoin('clndr_user', 'clndr_user.id = user_owner')
            ->groupBy('label')
            ->all();

        $i = 0;
        while ($i < count($friendsEvents)) {
            if(mb_strpos($friendsEvents[$i]['content'], ',', 0, 'UTF-8'))
            {
                foreach(explode(',', $friendsEvents[$i]['content']) as $date)
                {
                    $temp[] = Html::a(
                        $date,
                        ['/calendar/shared/'.$friendsEvents[$i]['id'].'/'.$date]
                    );
                    $friendsEvents[$i]['content'] = $temp;
                }
            } else
            {
                $friendsEvents[$i]['content'] = Html::a(
                    $friendsEvents[$i]['content'],
                    ['/calendar/shared/'.$friendsEvents[$i]['id'].'/'.$friendsEvents[$i]['content']]
                );
            }
            $i++;
        }

        return $friendsEvents;
    }
    
    /**
     * Check access current user by note
     * @param Calendar $model
     * @return bool|int
     */
    public static function checkAccess($model)
    {
        if($model->creator == Yii::$app->user->id)
        {
            return self::ACCESS_CREATOR;
        }
        $accessCalendar = self::find()
            ->withDate($model->getDateEvent())
            ->withGuest(Yii::$app->user->id)
            ->exists();
        
        if($accessCalendar)
            return self::ACCESS_GUEST;

        return false;
    }

    /**
     * Check logged user is creator or not
     *
     * @param Calendar $model
     * @return bool
     */
    public static function checkIsCreator ($model)
    {
        return self::checkAccess($model) == self::ACCESS_CREATOR;
    }

    /**
     * @inheritdoc
     * @return \app\models\query\AccessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\AccessQuery(get_called_class());
    }
}
