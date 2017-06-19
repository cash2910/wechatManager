<?php

namespace common\models;

use Yii;

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
            [['pay_sn', 'add_time', 'update_time'], 'required'],
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
            'order_sn' => 'Order Sn',
            'user_id' => 'User ID',
            'nick_name' => 'Nick Name',
            'mobile' => 'Mobile',
            'order_num' => 'Order Num',
            'status' => 'Status',
            'channel' => 'Channel',
            'pay_type' => 'Pay Type',
            'entity_id' => 'Entity ID',
            'pay_sn' => 'Pay Sn',
            'add_time' => 'Add Time',
            'update_time' => 'Update Time',
        ];
    }
}
