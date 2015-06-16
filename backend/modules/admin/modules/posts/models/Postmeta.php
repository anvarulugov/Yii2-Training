<?php

namespace backend\modules\admin\modules\posts\models;

use Yii;

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::className(), ['ID' => 'post_id']);
    }
}
