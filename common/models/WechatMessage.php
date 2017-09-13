<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "wechat_message".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $status
 * @property string $content
 * @property string $desc
 * @property string $open_id
 * @property string $num
 * @property stirng $send_time
 * @property string $add_time
 * @property string $update_time
 */
class WechatMessage extends \yii\db\ActiveRecord
{
    const STATUS_WAIT = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_FAIL = 2;
     
    const TYPE_ONE =1 ;
    const TYPE_ALL = 2;
    const TYPE_BD = 3;
    const TYPE_PLAYER = 4;
    
    static public $status_msg = [
        self::STATUS_WAIT =>'待发送',
        self::STATUS_SUCCESS =>'发送成功',
        self::STATUS_FAIL =>'发送失败'
    ];
    
    static public $type_msg = [
        self::TYPE_ONE =>'单个用户',
        self::TYPE_PLAYER =>'玩家用户',
        self::TYPE_BD =>'代理用户',
        self::TYPE_ALL =>'所有用户',
    ];
    
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'add_time',
                'updatedAtAttribute' => 'update_time',
                'value'   => function(){return $_SERVER['REQUEST_TIME'];},
            ],
       ];
    }
    
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
            [['type', 'status', 'num', 'add_time', 'update_time'], 'integer'],
            [['content'], 'string', 'max' => 200],
            [['desc', 'send_time'], 'string', 'max' => 30],
            [['open_id'], 'string', 'max' => 60],
            ['send_time', 'default', 'value' => '2017-09-01'],
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
            'desc' => '简述',
            'content' => '内容',
            'open_id' => 'OpenID',
            'num' => '推送数量',
            'send_time' => '定时发送',
            'add_time' => '添加时间',
            'update_time' => '更新时间',
        ];
    }
}
