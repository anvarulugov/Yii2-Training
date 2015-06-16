<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\admin\modules\posts\models\PostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Posts'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'post_parent',
            'post_name',
            'post_author',
            'post_date',
            // 'post_title:ntext',
            // 'post_content:ntext',
            // 'post_password',
            // 'post_modified',
            // 'post_status',
            // 'post_type',
            // 'comment_status',
            // 'comment_count',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
