<?php
$params = array_merge(
	require(__DIR__ . '/../../common/config/params.php'),
	require(__DIR__ . '/../../common/config/params-local.php'),
	require(__DIR__ . '/params.php'),
	require(__DIR__ . '/params-local.php')
);

return [
	'id' => 'app-backend',
	'basePath' => dirname(__DIR__),
	'controllerNamespace' => 'backend\controllers',
	'bootstrap' => ['log'],
	'modules' => [
		'admin' => [
			'class' => 'backend\modules\admin\Admin',
		]
	],
	'components' => [
		'utils' => [
			'class' => 'backend\components\Utils',
		],
		'view' => [
			'theme' => [
				'pathMap' => [
					'@backend/views' => '@backend/themes/adminlte',
					'@backend/modules/admin/modules/' => '@backend/themes/adminlte/modules'
				],
				'baseUrl' => '@backend/themes/adminlte',
			],
		],
		'user' => [
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => true,
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
	],
	'params' => $params,
];
