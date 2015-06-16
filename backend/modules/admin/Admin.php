<?php

namespace backend\modules\admin;

class Admin extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\admin\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->modules=[
			'posts' => [
				'class' => 'backend\modules\admin\modules\posts\Posts',
			],
		];
    }
}
