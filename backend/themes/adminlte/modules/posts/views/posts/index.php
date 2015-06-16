<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

$this->registerJsFile(Yii::$app->request->BaseUrl.'/media/plugins/bootstrap-select/js/bootstrap-select.min.js',['depends'=>[yii\bootstrap\BootstrapPluginAsset::className()]]);
$this->registerCssFile(Yii::$app->request->BaseUrl.'/media/plugins/bootstrap-select/css/bootstrap-select.min.css',['depends'=>[yii\bootstrap\BootstrapPluginAsset::className()]]);

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\admin\modules\posts\models\PostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">
	<h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<div class="box posts-form">
		<div class="box-body">
			<div id="posts-table" class="form-inline" role="grid">
				<div class="row">
					<div class="col-md-4 text-left">
						<?= Html::a('<i class="fa fa-plus"></i> '.Yii::t('app', 'New Post'), ['create'], ['class' => 'btn btn-xs btn-success']) ?>
					</div>
					<div class="col-md-8 text-right">
						<?php $post_search = ActiveForm::begin(['action'=>['posts/index'],'method'=>'get','options'=>['class'=>'form-inline']]); ?>
						<?= Html::activeTextInput($searchModel,'post_title', ['class'=>'form-control','placeholder'=>Yii::t('app','Enter post title...')]); ?>
						<?= Html::activeDropDownList($searchModel, 'post_terms', ArrayHelper::map($terms->find()->where(['term_type'=>'category'])->all(),'term_id','term_title'),['prompt'=>Yii::t('app','Any category'),'class'=>'form-control selectpicker col-md-4','data-live-search'=>'true','data-size'=>'10']) ?>
						<?= Html::activeDropDownList($searchModel, 'post_status', $model->status,['prompt'=>Yii::t('app','Any status'),'class'=>'form-control selectpicker col-md-2','data-size'=>'10']); ?>
						<?= Html::activeDropDownList($searchModel, 'post_author', ArrayHelper::map($user->find()->all(),'id','username'),['prompt'=>Yii::t('app','Any author'),'class'=>'form-control selectpicker col-md-2','data-size'=>'10']); ?>
						<?= Html::submitButton(Yii::t('app','Filter'), ['class' => 'btn btn-primary']) ?>
						<?php ActiveForm::end(); ?>
					</div>
				</div>
				<?php \yii\widgets\Pjax::begin(); ?>
				<?= GridView::widget([
					'dataProvider' => $dataProvider,
					'layout' => '{items}<div class="pull-right">{summary}</div>{pager}',
					//'filterModel' => $searchModel,
					'options' => ['class'=>'posts-table-container grid-view'],
					'tableOptions' => ['class'=>'table table-bordered table-striped posts-table'],
					'columns' => [
						['class' => 'yii\grid\SerialColumn'],

						[
							'attribute' => 'post_title',
							'filter' => false,
							'format' => 'raw',
							'value' => function($data) {
								$html = '<div class="post-title">';
								$html .= Html::a('<strong>'.$data->post_title.'</strong>',['posts/update','id'=>$data->ID]);
								$html .= '<div class="post-options">';
								$html .= Html::a(Yii::t('app','View'),'#',['target'=>'_blank']);
								$html .= ' | ';
								$html .= Html::a(Yii::t('app','Edit'),['posts/update','id'=>$data->ID]);
								$html .= ' | ';
								$html .= Html::a(Yii::t('app','Delete'),['posts/delete','id'=>$data->ID]);
								$html .='</div>';
								$html .='</div>';
								return $html;
							}
						],
						[
							'attribute' => 'post_terms',
							'label' => Yii::t('app','Categories'),
							'format' => 'raw',
							'value' => function($data) {
								$html = '';
								$last = count($data->terms);
								$i=1;
								foreach ($data->terms as $term) {
									$html .= Html::a($term->term_title,['posts/index','PostsSearch[post_terms]'=>$term->term_id]).($i>=$last ? '' : ', ');
									$i++;
								}
								return $html;
							},
						],
						//'ID',
						//'post_parent',
						//'post_name',
						[
							'attribute' => 'author.username',
							'label' => Yii::t('app','Author'),
							'filter' => false,
						],
						[
							'attribute' => 'post_date',
							'filter' => false,
						],
						
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
				<?php \yii\widgets\Pjax::end(); ?>
				<div class="row"></div>
			</div>
		</div>
	</div>
	
</div>
