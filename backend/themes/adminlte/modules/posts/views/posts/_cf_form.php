<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="row custom-field">
	<?php
		// necessary for update action.
		if (! $meta->isNewRecord) {
			echo Html::activeHiddenInput($meta, "[{$i}]meta_id");
		}
	?>
	<div class="col-md-5">
		<div class="form-group">
		<?= Html::activeTextInput($meta, "[{$i}]meta_key",['class'=>'form-control meta-key','readonly'=>'readonly']); ?>
		</div>
		<?= Html::a('<i class="glyphicon glyphicon-minus"></i> '.Yii::t('app', 'Delete'),'#',['class'=>'remove-item btn btn-danger btn-xs']); ?>
		<?= Html::a('<i class="glyphicon glyphicon-floppy-disk"></i> '.Yii::t('app', 'Update'),'#',['class'=>'update-item btn btn-primary btn-xs']); ?>
		<span class="result" style="display:none"></span>
	</div>
	<div class="col-md-7">
		<div class="form-group">
		<?= Html::activeTextarea($meta, "[{$i}]meta_value", ['rows' => 3, 'class'=>'form-control meta-value']); ?>
		</div>
	</div>
</div>
<?php $this->registerJs(
'
var _post_id = ' . ($meta->post_id ? $meta->post_id : 0) . ';
var csrfToken = $("meta[name=\"csrf-token\"]").attr("content");
var update_btn = "";
var delete_btn = "";
var delete_field = ""
$("#custom-fields").on("click",".remove-item",function(e){
	e.preventDefault();
	delete_btn = $(this);
	delete_field = $(delete_btn).parent().parent();
	if( confirm( "' . Yii::t('app','Are you sure you want to delete this item?') . '" ) ) {
		$.ajax({
			type: "post",
			cache: false,
			url: "' . Url::to(['posts/delete-meta']) . '",
			data: { post_id: _post_id, meta_id: $(delete_btn).parent().parent().find("[type=hidden]").val(), _csrf : csrfToken },
			success:function(response) {
				if( response == "deleted" ) {
					$(delete_field).animate({
						opacity: 0.25,
						left: "+=50",
						height: "toggle"
					},function() {
						$(delete_field).remove();
						$(".meta_keys .selectpicker").selectpicker("refresh");
					});
				}
			}
		});
	}
});
$("#custom-fields").on("click",".update-item",function(e){
	e.preventDefault();
	update_btn = $(this);
	update_field = $(update_btn).parent().parent().find(".result");
	var _meta_id = $(update_btn).parent().parent().find("[type=hidden]").val();
	var _meta_key = $(update_btn).parent().find(".meta-key").val();
	var _meta_value = $(update_btn).parent().parent().find(".meta-value").val();
	$.ajax({
		type: "post",
		cache: false,
		url: "' . Url::to(['posts/update-meta']) . '&meta_id=" + _meta_id,
		data: { Postmeta: { post_id: _post_id, meta_id: _meta_id, meta_key: _meta_key, meta_value: _meta_value }, _csrf: csrfToken },
		success:function(response) {
			if( response["error"] == 0 ) {
				$(update_field).addClass(".success");
				$(update_field).html(response["message"]);
				$(update_field).fadeIn().delay(3000).fadeOut();
			} else {
				$(update_field).addClass(".danger");
				$(update_field).html(response["message"]);
				$(update_field).fadeIn().delay(3000).fadeOut();
			}
		}
	});
});
',
$this::POS_END, 'deleteMeta'
); ?>