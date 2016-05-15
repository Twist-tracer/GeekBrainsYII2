<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Access */
/* @var $users array with 'id' => 'name' */

$this->title = Yii::t('app', 'Поделиться');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Публичные даты'), 'url' => ['publicdates']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form2.php', [
        'model' => $model,
        'users' => $users
    ]) ?>

</div>
