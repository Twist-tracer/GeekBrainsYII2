<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Calendar */

$this->title = 'Событие от '. $model->getDateTimeEvent();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Мои События'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'text:ntext',
            [
                'attribute' => 'user_name',
                'value' => $model->user->name . ' ' . $model->user->surname
            ],
            [
                'attribute' => 'date_event',
                'value' => $model->getDateTimeEvent()
            ],
        ],
    ]) ?>

</div>
