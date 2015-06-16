<?php 
namespace backend\components;
  
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

class Utils extends Component
{
	public function ActivateJsPlugin()
	{
		
		$plugins_dir = Yii::$app->homeUrl.'/media/plugins/';
		$this->registerJsFile($plugins_dir.'datepicker/bootstrap-date.js');
		$this->registerCssFile($plugins_dir.'datepicker/datepicker3.css', [
			'depends' => [BootstrapAsset::className()],
			'media' => 'all',
		], 'datepicker3');
	}

}