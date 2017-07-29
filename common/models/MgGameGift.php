<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "mg_game_gift".
 *
 * @property integer $id
 * @property integer $game_id
 * @property string $game_uid
 * @property string $data
 * @property integer $status
 * @property string $desc
 * @property integer $num
 * @property string $game_sn
 * @property string $apply_user
 * @property string $add_time
 * @property string $update_time
 */
class MgGameGift extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_game_gift';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'status', 'add_time', 'update_time','num'], 'integer'],
            [['game_uid', 'game_sn', 'apply_user'], 'string', 'max' => 30],
            [['data', 'desc'], 'string', 'max' => 100],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'game_id' => '游戏类别',
            'game_uid' => '用户游戏uid',
            'data' => 'Data',
            'num' => '赠送数量',
            'status' => '状态',
            'desc' => '赠送理由',
            'game_sn' => '游戏赠送sn',
            'apply_user' => '申请用户',
            'add_time' => '赠送时间',
            'update_time' => '更新时间',
        ];
    }
}
