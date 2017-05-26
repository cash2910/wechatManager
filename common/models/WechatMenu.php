<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "wechat_menu".
 *
 * @property integer $id
 * @property string $title
 * @property integer $type
 * @property string $add_time
 * @property string $update_time
 * @property integer $status
 * @property string $content
 */
class WechatMenu extends \yii\db\ActiveRecord
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
        return 'wechat_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status'], 'integer'],
            [['content'], 'required'],
            [['content','add_time','update_time'], 'string'],
            [['title'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '名称',
            'type' => '类型',
            'add_time' => '添加时间',
            'update_time' => '更新时间',
            'status' => '状态',
            'content' => 'Content',
        ];
    }
}
