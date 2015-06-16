<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\modules\posts\models\PostsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'post_parent') ?>

    <?= $form->field($model, 'post_name') ?>

    <?= $form->field($model, 'post_author') ?>

    <?= $form->field($model, 'post_date') ?>

    <?php // echo $form->field($model, 'post_title') ?>

    <?php // echo $form->field($model, 'post_content') ?>

    <?php // echo $form->field($model, 'post_password') ?>

    <?php // echo $form->field($model, 'post_modified') ?>

    <?php // echo $form->field($model, 'post_status') ?>

    <?php // echo $form->field($model, 'post_type') ?>

    <?php // echo $form->field($model, 'comment_status') ?>

    <?php // echo $form->field($model, 'comment_count') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
