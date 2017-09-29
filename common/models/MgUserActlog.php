<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mg_user_actlog".
 *
 * @property integer $id
 * @property string $union_id
 * @property integer $user_id
 * @property string $open_id
 * @property string $opt
 * @property string $num
 * @property string $data
 * @property string $add_time
 */
class MgUserActlog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_user_actlog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'add_time'], 'integer'],
            [['num'], 'number'],
            [['union_id'], 'string', 'max' => 50],
            [['open_id'], 'string', 'max' => 60],
            [['opt'], 'string', 'max' => 10],
            [['data'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'union_id' => 'Union ID',
            'user_id' => 'User ID',
            'open_id' => 'Open ID',
            'opt' => 'Opt',
            'num' => 'Num',
            'data' => 'Data',
            'add_time' => 'Add Time',
        ];
    }
}
