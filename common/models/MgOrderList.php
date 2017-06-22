<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "mg_order_list".
 *
 * @property integer $id
 * @property string $order_sn
 * @property integer $user_id
 * @property string $nick_name
 * @property string $mobile
 * @property string $order_num
 * @property integer $status
 * @property integer $channel
 * @property integer $pay_type
 * @property integer $entity_id
 * @property string $pay_sn
 * @property string $add_time
 * @property string $update_time
 */
class MgOrderList extends \yii\db\ActiveRecord
{
    
    const WAIT_PAY_STATUS = 0;     //待支付
    const WAIT_SEND_STATUS = 3;    //待收货
    const HAS_RECEIVE_STATUS = 5;  //已收货
    
    static $statDesc = [
        self::WAIT_PAY_STATUS=>'待支付',
        self::WAIT_SEND_STATUS=>'待收货',
        self::HAS_RECEIVE_STATUS=>'已收货',
    ];
    
    const WEIXIN_CHANNEL = 0;
    const CS_CHANNEL = 1;
    
    static $channelDesc = [
        self::CS_CHANNEL =>'手工订单',
        self::WEIXIN_CHANNEL => '微信订单',
    ];
    
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'add_time',
                'updatedAtAttribute' => 'update_time',
                'value'   => function(){return date( 'Y-m-d H:i:s', $_SERVER['REQUEST_TIME'] );},
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_order_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'channel', 'pay_type', 'entity_id'], 'integer'],
            [['order_num'], 'number'],
            //[['add_time', 'update_time'], 'required'],
            [['add_time', 'update_time'], 'safe'],
            [['order_sn', 'pay_sn'], 'string', 'max' => 32],
            [['nick_name'], 'string', 'max' => 40],
            [['mobile'], 'string', 'max' => 13],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_sn' => '订单编号',
            'user_id' => '用户id',
            'nick_name' => '用户昵称',
            'mobile' => '用户手机号',
            'order_num' => '订单金额',
            'status' => '订单状态',
            'channel' => '订单渠道',
            'pay_type' => '支付类型',
            'entity_id' => '商品id',
            'pay_sn' => '支付订单',
            'add_time' => '添加时间',
            'update_time' => '更新时间',
        ];
    }
}
