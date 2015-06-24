<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\modules\admin\modules\posts\models\Posts;
use backend\modules\admin\modules\posts\models\Terms;
/* @var $this yii\web\View */
/* @var $model app\modules\admin\modules\posts\models\Posts */
/* @var $form yii\widgets\ActiveForm */
use dosamigos\ckeditor\CKEditor;
use dosamigos\datepicker\DatePicker;
use dosamigos\selectize\SelectizeTextInput;

$this->registerJsFile(Yii::$app->request->BaseUrl.'/media/plugins/bootstrap-select/js/bootstrap-select.min.js',['depends'=>[yii\bootstrap\BootstrapPluginAsset::className()]]);
$this->registerCssFile(Yii::$app->request->BaseUrl.'/media/plugins/bootstrap-select/css/bootstrap-select.min.css',['depends'=>[yii\bootstrap\BootstrapPluginAsset::className()]])
?>
<div class="row">
<?php $form = ActiveForm::begin(); ?>
<div class="col-md-8">
	<div class="box posts-form">
		<div class="box-header">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#default" aria-controls="default" role="tab" data-toggle="tab"><?= Yii::t('app','Default') ?></a></li>
				<li role="presentation"><a href="#ru" aria-controls="ru" role="tab" data-toggle="tab"><?= Yii::t('app','Uzbek') ?></a></li>
				<li role="presentation"><a href="#uz" aria-controls="uz" role="tab" data-toggle="tab"><?= Yii::t('app','Russian') ?></a></li>
			</ul>
		</div>
		<div class="box-body">
			<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="default">
				<?= $form->field($model, 'post_title')->textInput() ?>
				<?= $form->field($model, 'post_content')->widget(CKEditor::className(), [
					'options' => ['rows' => 15],
					'preset' => 'custom',
					'clientOptions' => [
						'customConfig' => Yii::$app->request->BaseUrl.'/media/plugins/ckeditor/config.js',
					],
				]) ?>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="ru">
				<?= $form->field($model, 'post_title_ru')->textInput() ?>
				<?= $form->field($model, 'post_content_ru')->widget(CKEditor::className(), [
					'options' => ['rows' => 15],
					'preset' => 'custom',
					'clientOptions' => [
						'customConfig' => Yii::$app->request->BaseUrl.'/media/plugins/ckeditor/config.js',
					],
				]) ?>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="uz">
				<?= $form->field($model, 'post_title_uz')->textInput() ?>
				<?= $form->field($model, 'post_content_uz')->widget(CKEditor::className(), [
					'options' => ['rows' => 15],
					'preset' => 'custom',
					'clientOptions' => [
						'customConfig' => Yii::$app->request->BaseUrl.'/media/plugins/ckeditor/config.js',
					],
				]) ?>
			</div>
			</div>
		</div>
	</div>
	<div class="box posts-form-custom-fields">
		<div class="box-header ui-sortable-handle" style="cursor: move;">
			<h3 class="box-title"><?= Yii::t('app','Post Custom Fields'); ?></h3>
			<div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
			</div>
		  </div>
		<div class="box-body">
			<div class="custom-fields-container well"><!-- widgetBody -->
				<div id="custom-fields">
				<?php $custom_fields = [];
				$i = 0;
				if ( $model->metas ) :
				foreach ($model->metas as $meta) :
					$custom_fields[] = $meta->meta_key; ?>
					<?= $this->render('_cf_form',['meta'=>$meta,'i'=>$i]); ?>
					<?php $i++; ?>
				<?php endforeach; ?>
				<?php else : ?>
					<?= Yii::t('app','No custom fields for this item'); ?>
				<?php endif; ?>
				</div>
				<span class="error"></span>
			</div>
			<legend><small><?= Yii::t('app', 'Add new Custom field'); ?>:</small></legend>
			<div class="row">
				<div class="col-md-5 meta_keys">
					<?= $form->field($metas, 'meta_key')->dropDownList(ArrayHelper::map($metas->find()->all(),'meta_key','meta_key'),['prompt'=>Yii::t('app','Select'),'id'=>'meta_key','class'=>'form-control selectpicker','data-live-search'=>'true','data-size'=>'10']); ?>
					<div class="new-meta-name form-group" style="display:none;">
						<?= Html::activeTextInput($metas, 'meta_key', ['class'=>'form-control new-custom-field-name']); ?>
					</div>
					<?= Html::a(Yii::t('app','Cancel'),'#',['id'=>'canceladdNewMeta','style'=>'display:none;']); ?>&nbsp;
					<?= Html::a(Yii::t('app','New custom field'),'#',['id'=>'addNewMeta']); ?>&nbsp;
					<?= Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('app','Add custom field'),'#',['id'=>'loadMetaByAjax','class'=>'btn btn-success btn-xs']); ?>
				</div>
				<div class="col-md-7">
				<?= $form->field($metas, "meta_value")->textarea(['rows' => 3,'id'=>'meta_value']) ?>
				</div>
			</div>
		</div>
	</div>
</div><!--col-md-8-->
<div class="col-md-4 connectedSortable ui-sortable">
   <div class="box" style="position: relative;">
	  <div class="box-header ui-sortable-handle" style="cursor: move;">
		 <h3 class="box-title"><?= Yii::t('app','Publish'); ?></h3>
		 <div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
			<?=$form->errorSummary($model);?>
		</div>
	  </div>
	  <div class="box-body" style="display: block;">
		<?= $form->field($model, 'post_status')->dropDownList($model->status,['class'=>'form-control selectpicker','data-size'=>'10']) ?>
		<?= $form->field($model, 'post_date')->widget(DatePicker::className(), [
			'size' => 'md',
			'value' => Yii::$app->formatter->asDatetime($model->post_date, "php:d.m.Y H:i:s"),
			'clientOptions' => [
			   'autoclose' => true,
			   'format' => 'dd-mm-yyyy',
			   'todayHighlight' => true,
			]
		]);?>
	  </div><!-- /.box-body -->
	  <div class="box-footer" style="display: block;">
		 <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	  </div><!-- /.box-footer-->
   </div>
   <div class="box" style="position: relative;">
	  <div class="box-header ui-sortable-handle" style="cursor: move;">
		 <h3 class="box-title"><?= Yii::t('app','Categories'); ?></h3>
		 <div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
		</div>
	  </div>
	  <div class="box-body" style="display: block;">
		<?= $form->field($model, 'post_terms')->dropDownList(
			ArrayHelper::map(Terms::find()->where(['term_type'=>'category'])->all(),'term_id','term_title'),['prompt'=>Yii::t('app','Select Categories'),'class'=>'form-control selectpicker','data-live-search'=>'true','data-size'=>'10','multiple'=>'multiple']
		) ?>
	  </div><!-- /.box-body -->
   </div>
   <div class="box" style="position: relative;">
	  <div class="box-header ui-sortable-handle" style="cursor: move;">
		 <h3 class="box-title"><?= Yii::t('app','Tags'); ?></h3>
		 <div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
		</div>
	  </div>
	  <div class="box-body" style="display: block;">
		 <?= $form->field($model, 'post_tags')->widget(SelectizeTextInput::className(), [
			// calls an action that returns a JSON object with matched
			// tags
			'loadUrl' => ['posts/tags'],
			'options' => ['class' => 'form-control'],
			'clientOptions' => [
				'plugins' => ['remove_button'],
				'valueField' => 'term_name',
				'labelField' => 'term_name',
				'searchField' => ['term_name'],
				'create' => true,
			],
		])->hint('Use commas to separate tags') ?>
	  </div><!-- /.box-body -->
   </div>
   <div class="box" style="position: relative;">
	  <div class="box-header ui-sortable-handle" style="cursor: move;">
		 <h3 class="box-title"><?= Yii::t('app','Properties'); ?></h3>
		 <div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
		</div>
	  </div>
	  <div class="box-body" style="display: block;">
		 <?= $form->field($model, 'post_parent')->dropDownList(ArrayHelper::map(Posts::find()->where(['post_type'=>$type])->all(),'ID','post_title'),['prompt'=>Yii::t('app','Select Parent'),'class'=>'form-control selectpicker','data-live-search'=>'true','data-size'=>'10']) ?>
		 <?= $form->field($model, 'post_name')->textInput(['maxlength' => 255]) ?>
		 <?= $form->field($model, 'post_password')->textInput(['maxlength' => 200]) ?>
		 <?= $form->field($model, 'comment_status')->dropDownList($model->commentstatus,['class'=>'form-control selectpicker','data-size'=>'10']) ?>
	  </div><!-- /.box-body -->
   </div>
</div>
<?php ActiveForm::end(); ?>
</div><!--row-->
<?php $this->registerJs(
'	
	var csrfToken = $("meta[name=\"csrf-token\"]").attr("content");
	var _i = ' . $i . ';
	var _post_id = ' . (! $model->isNewRecord ? $model->ID : 0 ). ';
	$("#loadMetaByAjax").click(function(e){
		e.preventDefault();
		var _url = "' . Url::to(['posts/load-meta']) . '";
		$.ajax({
			type: "post",
			cache: false,
			data: { Postmeta: { post_id: _post_id, meta_key: $("#meta_key").val(), meta_value:  $("#meta_value").val() }, _csrf: csrfToken, i: _i },
			url: _url,
			success:function(response){
				if( response["error"] == 1 ) {
					$(".custom-fields-container .error").html(response["message"]);
				} else {
					$(".custom-fields-container .error").html("");
					$("#custom-fields").append(response);
					$("#custom-fields .custom-field").last().css({
						opacity : 0,
					});
					$("#custom-fields .custom-field").last().animate({
						opacity : 1, 
					});
					$("#meta_key").val("");
					$("#meta_value").val("");
				}

			}
		});
		_i++;
	});
	$("#addNewMeta").on("click",function(e){
		e.preventDefault();
		$(".meta_keys .selectpicker").selectpicker("hide");
		$(".meta_keys .selectpicker").attr("id","");
		$(".meta_keys .new-custom-field-name").attr("id","meta_key")
		$(".meta_keys .new-meta-name").show();
		$(this).hide();
		$("#canceladdNewMeta").show();
	});
	$("#canceladdNewMeta").on("click",function(e){
		e.preventDefault();
		$(".meta_keys .new-meta-name").hide();
		$(".meta_keys .new-custom-field-name").attr("id","")
		$(".meta_keys .selectpicker").attr("id","meta_key");
		$(this).hide();
		$(".meta_keys .selectpicker").selectpicker("show");
		$("#addNewMeta").show();
	});
',
$this::POS_END, 'loadMeta'
); ?>