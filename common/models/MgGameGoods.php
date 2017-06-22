<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "mg_game_goods".
 *
 * @property integer $id
 * @property string $game_id
 * @property string $title
 * @property string $price
 * @property integer $status
 * @property integer $type
 * @property string $content
 * @property string $add_time
 * @property string $update_time
 */
class MgGameGoods extends \yii\db\ActiveRecord
{
    const ON_SALE  = 1;
    const OFF_SALE = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_game_goods';
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
            [['game_id', 'status', 'type', 'add_time', 'update_time'], 'integer'],
            [['price'], 'number'],
            [['title'], 'string', 'max' => 20],
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
            'game_id' => '游戏id',
            'title' => '名称',
            'price' => '价格',
            'status' => '状态',
            'type' => '类型',
            'content' => '详细信息',
            'add_time' => '添加时间',
            'update_time' => '更新时间',
        ];
    }
}
