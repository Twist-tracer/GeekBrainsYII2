<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Calendar */

$this->title = 'Публичные даты';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Calendars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
        ]);
    ?>

</div>
