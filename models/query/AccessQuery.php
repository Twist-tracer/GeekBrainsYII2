<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Access]].
 *
 * @see \app\models\Access
 */
class AccessQuery extends \yii\db\ActiveQuery
{
    /**
     * Condition with id
     * @param string $date_event
     * @return $this
     */
    public function withDate($date_event)
    {
        return $this->andWhere(
            'date_event = :date_event',
            [
                ":date_event" => $date_event
            ]
        );
    }

    /**
     * Condition with $user_guest
     * @param int $user_guest
     * @return $this
     */
    public function withGuest($user_guest)
    {
        return $this->andWhere(
            'user_guest = :user_guest',
            [
                ":user_guest" => $user_guest
            ]
        );
    }

    /**
     * @inheritdoc
     * @return \app\models\Access[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Access|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
