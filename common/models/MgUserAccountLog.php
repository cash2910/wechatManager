<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mg_user_account_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $num
 * @property integer $c_type
 * @property string $content
 * @property integer $type
 * @property string $order_num
 * @property string $add_time
 */
class MgUserAccountLog extends \yii\db\ActiveRecord
{
    const INCOME = 1;
    const OUTCOME = 2;
    
    static public $msg = [
        self::INCOME =>'用户返利',
        self::OUTCOME=>'用户提现'
    ];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_user_account_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'num', 'add_time'], 'required'],
            [['user_id', 'c_type', 'type'], 'integer'],
            [['num','order_num'], 'number'],
            [['add_time'], 'safe'],
            [['content'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'num' => '金额',
            'c_type' => '详情',
            'content' => '描述',
            'type' => '类型',
            'order_num' => '订单金额',
            'add_time' => '添加时间',
        ];
    }
}
