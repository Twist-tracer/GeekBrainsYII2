<?php

use yii\helpers\Html;
use yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $model app\models\Calendar */
/* @var $dates */

$this->title = 'Публичные даты';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Мои события'), 'url' => ['/calendar/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
        Collapse::widget([
           'items' => $dates
       ]);
    ?>

</div>
