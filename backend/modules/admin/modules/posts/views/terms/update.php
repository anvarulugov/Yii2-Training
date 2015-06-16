<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\modules\posts\models\Terms */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Terms',
]) . ' ' . $model->term_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Terms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->term_id, 'url' => ['view', 'id' => $model->term_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="terms-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
