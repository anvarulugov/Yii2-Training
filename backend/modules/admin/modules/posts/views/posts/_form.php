<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\modules\posts\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'post_parent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_date')->textInput() ?>

    <?= $form->field($model, 'post_title')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'post_content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'post_password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_modified')->textInput() ?>

    <?= $form->field($model, 'post_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment_count')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
