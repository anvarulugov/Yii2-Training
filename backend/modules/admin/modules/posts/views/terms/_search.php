<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\modules\posts\models\TermsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="terms-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'term_id') ?>

    <?= $form->field($model, 'term_parent') ?>

    <?= $form->field($model, 'term_name') ?>

    <?= $form->field($model, 'term_title') ?>

    <?= $form->field($model, 'term_description') ?>

    <?php // echo $form->field($model, 'term_frequency') ?>

    <?php // echo $form->field($model, 'term_language') ?>

    <?php // echo $form->field($model, 'term_type') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
