<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mg_user_account".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $balance
 * @property string $free_balance
 * @property string $total_balance
 * @property string $total_num
 * @property string $update_time
 */
class MgUserAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_user_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'update_time'], 'required'],
            [['user_id'], 'integer'],
            [['balance', 'free_balance','total_balance','total_num'], 'number'],
            [['update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'balance' => 'Balance',
            'free_balance' => 'Free Balance',
            'update_time' => 'Update Time',
        ];
    }
}
