<?php

use yii\helpers\Html;
use yii\bootstrap\Collapse;


/* @var $this yii\web\View */
/* @var $dates array */

$this->title = Yii::t('app', 'События друзей');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
        Collapse::widget([
            'items' => $dates
        ]);
    ?>

</div>
