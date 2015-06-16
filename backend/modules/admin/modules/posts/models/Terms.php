<?php

namespace backend\modules\admin\modules\posts\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\helpers\Inflector;
Inflector::$transliterator = 'Uzbek-Latin/BGN; NFKD';
/**
 * This is the model class for table "terms".
 *
 * @property integer $term_id
 * @property integer $term_parent
 * @property string $term_name
 * @property string $term_title
 * @property string $term_description
 * @property string $term_language
 * @property string $term_type
 */
class Terms extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'terms';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'sluggable' => [
				'class' => SluggableBehavior::className(),
				'attribute' => 'term_title',
				'slugAttribute' => 'term_name',
			]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['term_parent','term_frequency'], 'integer'],
			[['term_name'], 'required'],
			['term_type', 'default', 'value'=>'tag'],
			['term_frequency', 'default', 'value'=>0],
			[['term_title', 'term_description'], 'string'],
			[['term_name'], 'string', 'max' => 255],
			[['term_language'], 'string', 'max' => 10],
			[['term_type'], 'string', 'max' => 100]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'term_id' => Yii::t('app', 'Term ID'),
			'term_parent' => Yii::t('app', 'Term Parent'),
			'term_name' => Yii::t('app', 'Term Name'),
			'term_title' => Yii::t('app', 'Term Title'),
			'term_description' => Yii::t('app', 'Term Description'),
			'term_frequency' => Yii::t('app', 'Term Frequency'),
			'term_language' => Yii::t('app', 'Term Language'),
			'term_type' => Yii::t('app', 'Term Type'),
		];
	}

	public function beforeSave($insert) {
		if(empty($this->term_title))
			$this->term_title = ucfirst($this->term_name);
		return parent::beforeSave($insert);
	}
}
