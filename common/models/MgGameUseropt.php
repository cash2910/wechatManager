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
 * @property string $update_time
 */
class MgGameUseropt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_game_useropt';
    }
    
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
    public function rules()
    {
        return [
            [['game_id', 'add_time', 'update_time'], 'integer'],
            [['union_id','ip'], 'string', 'max' => 50],
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
            'union_id' => 'UnionId',
            'opt_code' => '操作code',
            'game_id' => '游戏id',
            'data' => '详细数据',
            'ip' => 'Ip',
            'add_time' => '添加时间',
            'update_time' => 'Update Time',
        ];
    }
}
