<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\modules\posts\models\Postmeta */

$this->title = $model->meta_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Postmetas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="postmeta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->meta_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->meta_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'meta_id',
            'post_id',
            'meta_key',
            'meta_value:ntext',
        ],
    ]) ?>

</div>
