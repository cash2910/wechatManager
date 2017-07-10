<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "mg_rebate_list".
 *
 * @property integer $id
 * @property string $rebate_sn
 * @property string $user_id
 * @property integer $status
 * @property string $rebate_num
 * @property string $add_time
 * @property string $update_time
 */
class MgRebateList extends \yii\db\ActiveRecord
{
    const APPLY  = 0;
    const CONFIRM = 1;
    const REJECT = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_rebate_list';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'add_time',
                'updatedAtAttribute' => 'update_time',
                'value'   => function(){return  $_SERVER['REQUEST_TIME']; }
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rebate_sn'], 'required'],
            [['user_id', 'status', 'add_time', 'update_time'], 'integer'],
            [['rebate_num'], 'number'],
            [['rebate_sn'], 'string', 'max' => 32],
            [['desc'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rebate_sn' => 'Rebate Sn',
            'user_id' => 'User ID',
            'status' => 'Status',
            'rebate_num' => 'Rebate Num',
            'add_time' => 'Add Time',
            'update_time' => 'Update Time',
        ];
    }
}
