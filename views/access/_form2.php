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

    <label class="control-label" for="access-user_guest">Выберете пользователя</label>
    <?= $form->field($model, 'user_guest', ['template' => '{input}{hint}{error}'])->dropDownList($users);  ?>

    <label class="control-label" for="access-date">Дата</label>
    <?= $form->field($model, 'date', ['template' => '{input}{hint}{error}'])->widget(DatePicker::className(), [
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Поделиться'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
