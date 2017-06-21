<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "mg_game_useropt".
 *
 * @property integer $id
 * @property string $union_id
 * @property string $opt_code
 * @property integer $game_id
 * @property string $data
 * @property string $ip
 * @property string $add_time
 */
class MgGameUseropt extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'add_time',
                'updatedAtAttribute' => 'update_time',
                'value'   => function(){return $_SERVER['REQUEST_TIME'];},
            ]
         ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_game_useropt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'opt_code', 'game_id','ip'], 'required'],
            [['game_id', 'add_time','update_time'], 'integer'],
            [['union_id'], 'string', 'max' => 50],
            [['opt_code', 'ip'], 'string', 'max' => 20],
            [['data'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'union_id' => 'union_id',
            'opt_code' => '行为类型',
            'game_id' => '游戏id',
            'data' => 'Data',
            'ip' => 'Ip地址',
            'add_time' => 'Add Time',
        ];
    }
}
