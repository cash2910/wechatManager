<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "wechat_user_tag".
 *
 * @property integer $id
 * @property string $tag_name
 * @property integer $tag_id
 * @property string $add_time
 * @property string $update_time
 * @property integer $status
 */
class WechatUserTag extends \yii\db\ActiveRecord
{
    
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'add_time',
                'updatedAtAttribute' => 'update_time', 
                'value'   => function(){return date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']);},
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_user_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id', 'status','count'], 'integer'],
            [['tag_name','add_time', 'update_time'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_name' => 'Tag Name',
            'tag_id' => 'Tag ID',
            'add_time' => 'Add Time',
            'update_time' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
