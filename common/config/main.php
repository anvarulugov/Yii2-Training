<?php
return [
	'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
	'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'formatter' => [
			'class' => 'yii\i18n\Formatter',
			'dateFormat' => 'php:d.m.Y',
			'datetimeFormat' => 'php:d.m.Y H:i:s',
			'timeFormat' => 'php:H:i:s',
		],
		/*
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'enableStrictParsing' => false,
			'rules' => [
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			],
		],
		*/
	],
];
