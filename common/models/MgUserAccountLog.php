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
 * @property string $add_time
 */
class MgUserAccountLog extends \yii\db\ActiveRecord
{
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
            [['num'], 'number'],
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
            'user_id' => 'User ID',
            'num' => 'Num',
            'c_type' => 'C Type',
            'content' => 'Content',
            'type' => 'Type',
            'add_time' => 'Add Time',
        ];
    }
}
