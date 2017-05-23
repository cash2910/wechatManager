<?php

namespace common\models;

use Yii;

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
            'title' => 'Title',
            'type' => 'Type',
            'add_time' => 'Add Time',
            'update_time' => 'Update Time',
            'status' => 'Status',
            'content' => 'Content',
        ];
    }
}
