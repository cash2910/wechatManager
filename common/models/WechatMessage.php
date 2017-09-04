<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wechat_message".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $status
 * @property string $content
 * @property string $open_id
 * @property string $num
 * @property string $add_time
 * @property string $update_tie
 */
class WechatMessage extends \yii\db\ActiveRecord
{
    const STATUS_WAIT = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_FAIL = 2;
     
    const TYPE_ONE =1 ;
    const TYPE_ALL = 2;
    
    static public $status_msg = [
        self::STATUS_WAIT =>'待发送',
        self::STATUS_SUCCESS =>'发送成功',
        self::STATUS_FAIL =>'发送失败'
    ];
    
    static public $type_msg = [
        self::TYPE_ONE =>'单个用户',
        self::TYPE_ALL =>'所有用户',
    ];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'num', 'add_time', 'update_tie'], 'integer'],
            [['content'], 'string', 'max' => 200],
            [['open_id'], 'string', 'max' => 60],
          //  ['num', 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '消息类型',
            'status' => '状态',
            'content' => '内容',
            'open_id' => 'OpenID',
            'num' => '推送数量',
            'add_time' => '添加时间',
            'update_tie' => '更新时间',
        ];
    }
}
