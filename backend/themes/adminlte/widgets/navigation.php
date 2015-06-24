<?php
use yii\widgets\Menu;

echo Menu::widget([
	'options' => ['class'=>'sidebar-menu'],
	'activateParents'=>true,
	'activateItems'=>true,
	'activeCssClass'=>'active',
	'encodeLabels'=>false,
	'submenuTemplate'=>"\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
	'items' => [
		[
			'label'=>'<i class="glyphicon glyphicon-pushpin"></i> Posts',
			'itemOptions'=>['class'=>'treeview active'],
			'url'=>['posts/index'],
			'items'=>[
				[
					'label' => 'All Posts', 
					'url' => ['posts/index', 'type' => 'post'],
				],
				[
					'label' => 'Add New', 
					'url' => ['posts/create', 'type' => 'post'],
				],
				[
					'label' => 'Categories', 
					'url' => ['terms/index', 'type' => 'category'],
				],
				[
					'label' => 'Tags', 
					'url' => ['terms/index', 'type' => 'tags'],
				],
			],
			//'visible'=>$this->user->checkAccess(array('admin','manager','accountant')),
		],
		[
			'label'=>'<i class="glyphicon glyphicon-file"></i> Pages',
			'itemOptions'=>['class'=>'treeview active'],
			'url'=>['posts/index'],
			'items'=>[
				[
					'label' => 'All Pages', 
					'url' => ['posts/index', 'type' => 'page'],
				],
				[
					'label' => 'Add New', 
					'url' => ['posts/create', 'type' => 'page'],
				],
			],
			//'visible'=>$this->user->checkAccess(array('admin','manager','accountant')),
		],
		['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
	],
]);
?>