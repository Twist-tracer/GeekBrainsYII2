<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use app\models\Calendar;
use yii\grid\GridView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CalendarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'События друга').' '.User::findOne($id)->name . ' ' . User::findOne($id)->surname
    .' за '.Yii::$app->formatter->asDate($date, 'dd/MM/yyyy');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //'id',
            //'text:ntext',
            [
                'attribute' => 'text',
                'content' => function ($model) {
                    return Html::a($model->text, ['/calendar/view/' . $model->id]);
                }
            ],
            //'creator',
            //'date_event_start',
            [
                'attribute' => 'date_event',
                'content' => function($model){
                    return $model->getDateTimeEvent();
                }
            ],
        ],
    ]); ?>

</div>
