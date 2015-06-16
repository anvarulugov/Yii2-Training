<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\admin\modules\posts\models\Postmeta */

$this->title = Yii::t('app', 'Create Postmeta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Postmetas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="postmeta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
