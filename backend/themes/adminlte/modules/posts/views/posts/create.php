<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\modules\posts\models\Posts */

$this->title = Yii::t('app', 'Create Posts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', [
	'model' => $model,
	'metas' => $metas,
	'type' => $type,
]) ?>
