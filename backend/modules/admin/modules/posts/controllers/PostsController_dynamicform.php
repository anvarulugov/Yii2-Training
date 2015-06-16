<?php

namespace backend\modules\admin\modules\posts\controllers;

use Yii;
use backend\modules\admin\modules\posts\models\Terms;
use backend\modules\admin\modules\posts\models\TermsSearch;
use backend\modules\admin\modules\posts\models\TermRelations;
use backend\modules\admin\modules\posts\models\Model;
use backend\modules\admin\modules\posts\models\Postmeta;
use backend\modules\admin\modules\posts\models\Posts;
use backend\modules\admin\modules\posts\models\PostsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
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
		$metas = [new Postmeta];
		if ($model->load(Yii::$app->request->post())) {

			$model->post_type = $type;
			$model->comment_count = 0;
			$model->post_author = Yii::$app->user->identity->id;

			$metas = Model::createMultiple(Postmeta::classname());
			Model::loadMultiple($metas, Yii::$app->request->post());

			// ajax validation
			if (Yii::$app->request->isAjax) {
				Yii::$app->response->format = Response::FORMAT_JSON;
				return ArrayHelper::merge(
					ActiveForm::validateMultiple($metas),
					ActiveForm::validate($model)
				);
			}

			// validate all models
			$valid = $model->validate();
			$valid = Model::validateMultiple($metas) && $valid;

			if ($valid) {
				$transaction = \Yii::$app->db->beginTransaction();
				try {
					if ($flag = $model->save(false)) {
						foreach ($metas as $meta) {
							$meta->customer_id = $model->id;
							if (! ($flag = $meta->save(false))) {
								$transaction->rollBack();
								break;
							}
						}
					}
					if ($flag) {
						$transaction->commit();
						return $this->redirect(['view', 'id' => $model->id]);
					}
				} catch (Exception $e) {
					$transaction->rollBack();
				}
			}
			
		} else {
			return $this->render('create', [
				'model' => $model,
				'metas' => (empty($metas)) ? [new Postmeta] : $metas,
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
			$oldIDs = ArrayHelper::map($metas, 'meta_id', 'meta_id');
			$metas = Model::createMultiple(Postmeta::classname(), $metas);
			Model::loadMultiple($metas, Yii::$app->request->post());
			$deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($metas, 'meta_id', 'meta_id')));

			// ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($metas),
                    ActiveForm::validate($model)
                );
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($metas) && $valid;


			if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            Address::deleteAll(['meta_id' => $deletedIDs]);
                        }
                        foreach ($metas as $meta) {
                            $meta->post_id = $model->ID;
                            if (! ($flag = $meta->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->ID]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
		}
		return $this->render('update', [
			'model' => $model,
			'metas' => (empty($metas)) ? [new Postmeta] : $metas,
			'type' => $type,
		]);
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
		if (($model = Posts::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}
