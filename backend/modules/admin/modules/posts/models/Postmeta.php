<?php

namespace backend\modules\admin\modules\posts\models;

use Yii;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
/**
 * This is the model class for table "postmeta".
 *
 * @property string $meta_id
 * @property string $post_id
 * @property string $meta_key
 * @property string $meta_value
 *
 * @property Posts $post
 */
class Postmeta extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'postmeta';
	}

	public function behaviors()
	{
		return [
			'ml' => [
				'class' => MultilingualBehavior::className(),
				'languages' => [
					'uz' => 'Uzbek',
					'ru' => 'Russian',
					'en' => 'English',
				],
				'languageField' => 'meta_lang',
				//'localizedPrefix' => '',
				'requireTranslations' => true,
				//'dynamicLangClass' => false,
				//'langClassName' => PostsLang::className(), // or namespace/for/a/class/PostLang
				'defaultLanguage' => 'en',
				'langForeignKey' => 'meta_id',
				'tableName' => "{{%postmeta_lang}}",
				'attributes' => [
					'meta_value',
				]
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['post_id'], 'required'],
			[['post_id'], 'integer'],
			[['meta_value'], 'string'],
			[['meta_key'], 'string', 'max' => 255]
		];
	}

	public function transactions()
	{
		return [
			self::SCENARIO_DEFAULT => self::OP_ALL,
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'meta_id' => Yii::t('app', 'Meta ID'),
			'post_id' => Yii::t('app', 'Post ID'),
			'meta_key' => Yii::t('app', 'Name'),
			'meta_value' => Yii::t('app', 'Value'),
		];
	}

	public static function find()
	{
		return new MultilingualQuery(get_called_class());
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPost()
	{
		return $this->hasOne(Posts::className(), ['ID' => 'post_id']);
	}
}
