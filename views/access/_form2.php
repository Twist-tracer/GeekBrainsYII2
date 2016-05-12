<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Access */
/* @var $form yii\widgets\ActiveForm */
/* @var $users array with 'id' => 'name' */
?>

<div class="access-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_guest')->dropDownList($users);  ?>

    <?= $form->field($model, 'date')->textInput(['class' => 'form-control'])->widget(DatePicker::className(), [
        'name' => 'date',
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Поделиться'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
