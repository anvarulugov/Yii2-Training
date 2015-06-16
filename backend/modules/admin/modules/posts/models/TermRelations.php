<?php

namespace backend\modules\admin\modules\posts\models;

use Yii;

/**
 * This is the model class for table "term_relations".
 *
 * @property string $id
 * @property string $object_id
 * @property integer $term_id
 *
 * @property Terms $term
 * @property Posts $post
 */
class TermRelations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'term_relations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id', 'term_id'], 'required'],
            [['object_id', 'term_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'object_id' => Yii::t('app', 'Post ID'),
            'term_id' => Yii::t('app', 'Term ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerm()
    {
        return $this->hasOne(Terms::className(), ['term_id' => 'term_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::className(), ['ID' => 'object_id']);
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        $frequency = $this->find()->where(['object_id'=>$this->object_id])->count();
        $term = Terms::find()->where(['id'=>$this->term_id]);
        $term->term_frequency = $frequency;
        $term->save();
    }
}
