<?php

namespace backend\modules\admin\modules\posts\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use dosamigos\taggable\Taggable;
use common\models\User;
//use creocoder\taggable\TaggableBehavior;
use yii\db\Expression;
use yii\helpers\Inflector;
Inflector::$transliterator = 'Uzbek-Latin/BGN; NFKD';
/**
 * This is the model class for table "posts".
 *
 * @property string $ID
 * @property string $post_parent
 * @property string $post_name
 * @property string $post_author
 * @property string $post_date
 * @property string $post_title
 * @property string $post_content
 * @property string $post_password
 * @property string $post_modified
 * @property string $post_status
 * @property string $post_type
 * @property string $comment_status
 * @property string $comment_count
 * @property Postmeta[] $postmetas
 * @property Postcategories $postTerms
 */
class Posts extends \yii\db\ActiveRecord
{

	public $post_terms;
	public $post_tags;
	public $post_metas;
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'posts';
	}

	public function behaviors()
	{
		return [
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'post_title',
				'slugAttribute' => 'post_name',
				'ensureUnique'=>true,
			],
			[
				'class' => TimestampBehavior::className(),
				'createdAtAttribute' => 'post_date',
				'updatedAtAttribute' => 'post_modified',
				'value' => new Expression('NOW()'),
			],
			// [
			// 	'class' => Taggable::className(),
			// 	'attribute' => 'post_tags',
			// 	'name' => 'term_name',
			// 	//'relation' => 'tags',
			// 	'frequency' => 'term_frequency',
			// ],
			// [
			// 	'class' => TaggableBehavior::className(),
			// 	'tagValuesAsArray' => false,
			// 	'tagRelation' => 'terms',
			// 	'tagValueAttribute' => 'term_name',
			// 	'tagFrequencyAttribute' => 'term_frequency',
			// ],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['post_parent', 'post_author', 'comment_count'], 'integer'],
			[['post_author'], 'required'],
			[['post_date', 'post_modified', 'post_terms', 'post_tags', 'post_metas'], 'safe'],
			[['post_title', 'post_content'], 'string'],
			[['post_name'], 'string', 'max' => 255],
			[['post_password'], 'string', 'max' => 200],
			[['post_status', 'post_type', 'comment_status'], 'string', 'max' => 20],
			[['post_name'], 'unique']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'ID' => Yii::t('app', 'ID'),
			'post_parent' => Yii::t('app', 'Parent'),
			'post_name' => Yii::t('app', 'Slug'),
			'post_author' => Yii::t('app', 'Author'),
			'post_date' => Yii::t('app', 'Publish Date'),
			'post_title' => Yii::t('app', 'Title'),
			'post_content' => Yii::t('app', 'Content'),
			'post_password' => Yii::t('app', 'Password'),
			'post_modified' => Yii::t('app', 'Modified Date'),
			'post_status' => Yii::t('app', 'Status'),
			'post_type' => Yii::t('app', 'Type'),
			'comment_status' => Yii::t('app', 'Discussion'),
			'comment_count' => Yii::t('app', 'Comment Count'),
		];
	}

	public function getStatus() {
		$status =  [
			['key' => 'default', 'value' => Yii::t('app','Default')],
			['key' => 'public', 'value' => Yii::t('app','Public')],
			['key' => 'private', 'value' => Yii::t('app','Private')],
			['key' => 'draft', 'value' => Yii::t('app','Draft')],
		];

		$status = ArrayHelper::map($status,'key','value');
		return $status;
	}

	public function getCommentstatus() {
		$commentstatus = [
			['key' => 'default', 'value' => Yii::t('app','Default')],
			['key' => 'users', 'value' => Yii::t('app','Users')],
			['key' => 'none', 'value' => Yii::t('app','None')],
			['key' => 'any', 'value' => Yii::t('app','Any')],
		];
		$commentstatus = ArrayHelper::map($commentstatus,'key','value');
		return $commentstatus;
	}

	public function transactions()
	{
		return [
			self::SCENARIO_DEFAULT => self::OP_ALL,
		];
	}

	public function getAuthor() {
		return $this->hasOne(User::className(),['id'=>'post_author']);
	}

	/**
	 * Metas relation, magic funciton to generate public property
	 * @return \yii\db\ActiveQuery
	 */
	public function getMetas()
	{
		return $this->hasMany(Postmeta::className(), ['post_id' => 'ID']);
	}

	/**
	 * Terms relation, magic funciton to generate public property
	 * @return \yii\db\ActiveQuery
	 */
	public function getTerms()
	{
		return $this->hasMany(Terms::className(), ['term_id' => 'term_id'])
					->viaTable(TermRelations::tableName(), ['object_id' => 'ID'])
					->andWhere(['term_type'=>'category']);
	}

	/**
	 * Tags relation, magic funciton to generate public property
	 * @return \yii\db\ActiveQuery
	 */
	public function getTags()
	{
		return $this->hasMany(Terms::className(), ['term_id' => 'term_id'])
					->viaTable(TermRelations::tableName(), ['object_id' => 'ID'])
					->andWhere(['term_type'=>'tag']);
	}

	/**
	 * Reformat tags from array to string, to display in view
	 * @return [string] [$tags]
	 */
	public function getTagsAsString() {
		$tags = '';
		foreach ($this->tags as $tag) {
			$tags .= $tag->term_name.', ';
		}
		return $tags;
	}

	/**
	 * Reformat posted tags as array with saving new ones before setting value to $this->post_tags
	 * @return [object] [$this->post_tags]
	 */
	public function getTagsAsArray() {
		if(!is_array($this->post_tags)) {
			$post_tags = str_replace(', ', ',', $this->post_tags);
			$post_tags = str_replace(' ,', ',', $this->post_tags);
			$post_tags = explode(',', $post_tags);
		} else {
			$post_tags = $this->post_tags;
		}
		$tags = [];
		foreach ($post_tags as $tag) {
			$tag = ltrim($tag);
			$tag_name = Inflector::slug($tag);
			$term = Terms::find()->where(['term_name'=>$tag_name])->one();
			if(!isset($term->term_id)) {
				$new_term = new Terms();
				$new_term->term_title = ucfirst($tag);
				if($new_term->save()) {
					$tags[] = $new_term;
				}
			} else {
				$tags[] = $term;
			}
		}
		$this->post_tags = $tags;
	}

	/**
	 * Event before saving post
	 * @param  [type] $insert [description]
	 * @return [type]         [description]
	 */
	public function beforeSave($insert) {
		// Reformat posted tags as array with saving new ones before returning
		$this->getTagsAsArray();
		// Call parent beforeSave event to handle other processes
		return parent::beforeSave($insert);
	}

	/**
	 * Event after saving post
	 * @param  [type] $insert            [description]
	 * @param  [type] $changedAttributes [description]
	 * @return [type]                    [description]
	 */
	public function afterSave($insert, $changedAttributes)
	{

		/**
		 * Unlink terms and tags relations. Further new relations will linked.
		 */
		$this->unlinkAll('terms',true);
		$this->unlinkAll('tags',true);

		// Call of parent afterSave event to handle other processes
		parent::afterSave($insert, $changedAttributes);

		/**
		 * Linking post with categories via term_relations table
		 * @var TermRelations
		 */
		$term_relations = new TermRelations();
		$term_relations->object_id = $this->ID;
		if(is_array($this->post_terms)) {
			foreach ($this->post_terms as $term) {
				$term = Terms::findOne($term);
				$term_relations->term_id = $term->term_id;
				$this->link('terms',$term,$term_relations);
			}
		}
		/**
		 * Linking post with tags via term_relations table
		 * @var TermRelations
		 */
		$tag_relations = new TermRelations();
		$tag_relations->object_id = $this->ID;
		if(is_array($this->post_tags)) {
			foreach ($this->post_tags as $tag) {
				$tag = Terms::findOne($tag->term_id);
				$tag_relations->term_id = $tag->term_id;
				$this->link('tags',$tag,$tag_relations);
			}
		}

		foreach ($this->post_metas as $post_meta) {
			$meta = Postmeta::findOne($post_meta['meta_id']);
			$meta->post_id = $this->ID;
			$meta->meta_value = $post_meta['meta_value'];
			$meta->save();
		}

	}

	public function beforeDelete()
	{
		if (parent::beforeDelete()) {
			// Delete all relations with categories
			$this->unlinkAll('terms',true);
			// Delete all relations with tags
			$this->unlinkAll('tags',true);
			// Delete all post metas related to this post
			$this->unlinkAll('metas',true);
			return true;
		} else {
			return false;
		}
	}
}
