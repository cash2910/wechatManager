<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "mg_users".
 *
 * @property integer $id
 * @property string $nickname
 * @property string $user_logo
 * @property integer $status
 * @property string $open_id
 * @property string $passwd
 * @property integer $is_bd
 * @property string $mobile
 * @property integer $register_time
 * @property integer $update_time
 * @property string $user_rels
 */
class MgUsers extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
             [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'register_time',
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
        return 'mg_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'is_bd', 'register_time', 'update_time'], 'integer'],
            [['nickname', 'user_rels'], 'string', 'max' => 30],
            [['user_logo'],'string','max'=>200],
            [['open_id'], 'string', 'max' => 60],
            [['passwd'], 'string', 'max' => 70],
            [['mobile'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => 'Nickname',
            'status' => 'Status',
            'open_id' => 'Open ID',
            'passwd' => 'Passwd',
            'is_bd' => 'Is Bd',
            'mobile' => 'Mobile',
            'register_time' => 'Register Time',
            'update_time' => 'Update Time',
            'user_rels' => 'User Rels',
        ];
    }
}
