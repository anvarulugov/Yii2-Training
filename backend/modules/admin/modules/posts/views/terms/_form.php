<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\modules\posts\models\Terms */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="terms-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'term_parent')->textInput() ?>

    <?= $form->field($model, 'term_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'term_title')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'term_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'term_frequency')->textInput() ?>

    <?= $form->field($model, 'term_language')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'term_type')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
