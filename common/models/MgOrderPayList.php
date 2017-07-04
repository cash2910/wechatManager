<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mg_order_pay_list".
 *
 * @property integer $id
 * @property string $pay_sn
 * @property string $order_sn
 * @property integer $pay_type
 * @property string $pay_num
 * @property string $pay_time
 */
class MgOrderPayList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_order_pay_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pay_time'], 'required'],
            [['pay_type'], 'integer'],
            [['pay_num'], 'number'],
            [['pay_time'], 'safe'],
            [['pay_sn', 'order_sn'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_sn' => 'Pay Sn',
            'order_sn' => 'Order Sn',
            'pay_type' => 'Pay Type',
            'pay_num' => 'Pay Num',
            'pay_time' => 'Pay Time',
        ];
    }
}
