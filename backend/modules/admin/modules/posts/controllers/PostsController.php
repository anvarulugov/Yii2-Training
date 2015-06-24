<?php

namespace backend\modules\admin\modules\posts\controllers;

use Yii;
use backend\modules\admin\modules\posts\models\Terms;
use backend\modules\admin\modules\posts\models\TermsSearch;
use backend\modules\admin\modules\posts\models\TermRelations;
use backend\modules\admin\modules\posts\models\Posts;
use backend\modules\admin\modules\posts\models\PostsSearch;
use backend\modules\admin\modules\posts\models\Postmeta;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostsController implements the CRUD actions for Posts model.
 */
class PostsController extends Controller
{
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
					'delete-meta' => ['post'],
				],
			],
		];
	}

	/**
	 * Lists all Posts models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new PostsSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$terms = new Terms();
		$model = new Posts();
		$user = new User();

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'terms' => $terms,
			'model' => $model,
			'user' => $user,
		]);
	}

	/**
	 * Displays a single Posts model.
	 * @param string $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Posts model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate($type = 'post')
	{
		$model = new Posts();

		if ($model->load(Yii::$app->request->post())) {
			$model->post_type = $type;
			$model->comment_count = 0;
			$model->post_author = Yii::$app->user->identity->id;
			$post_metas = Yii::$app->request->post('Postmeta');
			unset($post_metas['meta_key']);
			unset($post_metas['meta_value']);
			$model->post_metas = $post_metas;
			if($model->load(Yii::$app->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id' => $model->ID]);
			}
		} else {
			return $this->render('create', [
				'model' => $model,
				'metas' => new Postmeta,
				'type' => $type,
			]);
		}
	}

	/**
	 * Updates an existing Posts model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionUpdate($id, $type = 'post')
	{
		$model = $this->findModel($id);
		$model->post_terms = $model->terms;
		$model->post_tags = $model->TagsAsString;
		$metas = $model->metas;
		
		if ($model->load(Yii::$app->request->post())) {
			$post_metas = Yii::$app->request->post('Postmeta');
			unset($post_metas['meta_key']);
			unset($post_metas['meta_value']);
			$model->post_metas = $post_metas;
			if ($model->save()) {
				return $this->redirect(['view', 'id' => $model->ID]);
			}
		} else {
			return $this->render('update', [
			   'model' => $model,
			   'metas' => new Postmeta,
			   'type' => $type,
			]);
		}
	}

	public function actionTags($query)
	{
		$models = Terms::find()->where(['term_type'=>'tag'])->andWhere(['like','term_name', $query])->limit(50)->all();
		$items = [];

		foreach ($models as $model) {
			$items[] = ['term_name' => $model->term_name];
		}
		// We know we can use ContentNegotiator filter
		// this way is easier to show you here :)
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		return $items;
	}
	/*
	public function actionMetas($query)
	{
		$models = Postmeta::find()->where(['like','meta_key', $query])->limit(50)->all();
		$items = [];

		foreach ($models as $model) {
			$items[] = ['meta_key' => $model->meta_key];
		}
		// We know we can use ContentNegotiator filter
		// this way is easier to show you here :)
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		return $items;
	}
	*/
	public function actionLoadMeta() {
		$model = new Postmeta();
		if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
			if ( Postmeta::find()->where(['meta_key' => $model->meta_key,'post_id'=>$model->post_id])->One() ) {
				$response = ['error'=>1,'message'=>Yii::t('app','This meta has been added already, please, update it, if you want to set another value.')];
				Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				return $response;
			} else {
				if ( ! empty( $model->meta_key) && $model->validate() ) {
					$model->save();
					$i = Yii::$app->request->post('i');
					return $this->renderPartial('_cf_form',['meta'=>$model,'i'=>$i]);
				} else {
					$response = ['error'=>1,'message'=>Yii::t('app','Meta name cannot be blank')];
					Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
					return $response;
				}
			}
		}
	}
	public function actionUpdateMeta($meta_id)
	{
		//$model = Postmeta::findOne($meta_id);
		$model = Postmeta::find()->multilingual()->andWhere(['meta_id' => $meta_id])->one();
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if (Yii::$app->request->isAjax) {
				$response = ['error'=>0,'message'=>Yii::t('app','Updated.')];
				Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				return $response;
			}
		} else {
			if (Yii::$app->request->isAjax) {
				$response = ['error'=>1,'message'=>Yii::t('app','Not updated.')];
				Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				return $response;
			}
		}
	}
	public function actionDeleteMeta()
	{
		$model = new Postmeta();
		if ($model->validate(Yii::$app->request->post())) {
			$model->findOne(Yii::$app->request->post('meta_id'))->delete();
			if (Yii::$app->request->isAjax) {
				echo 'deleted';
			} else {
				return $this->redirect(['index']);
			}
		}
		

		
	}
	/**
	 * Deletes an existing Posts model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param string $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Posts model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param string $id
	 * @return Posts the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
    {
        if (($model = Posts::find()->multilingual()->andWhere(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
