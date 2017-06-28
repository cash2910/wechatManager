<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "mg_games".
 *
 * @property integer $id
 * @property string $title
 * @property string $desc
 * @property integer $status
 * @property integer $type
 * @property string $url
 * @property string $pic_url
 * @property string $add_time
 * @property string $update_time
 * @property string $remark
 */
class MgGames extends \yii\db\ActiveRecord
{
    const IS_ONLINE = 0;
    const IS_OFFLINE =1;
    
    static $statDesc = [
        self::IS_ONLINE=>'上线',
        self::IS_OFFLINE=>'下线'
    ];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_games';
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
            [['status', 'type', 'add_time', 'update_time'], 'integer'],
            [['title'], 'string', 'max' => 30],
            [['desc','pic_url','url'], 'string', 'max' => 200],
            [['remark'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '游戏名称',
            'desc' => '游戏简介',
            'status' => '游戏状态',
            'type' => '游戏类型',
            'pic_url'=>'banner图片链接',
            'url' =>'游戏链接',
            'add_time' => '添加时间',
            'update_time' => '更新时间',
            'remark' => '备注',
        ];
    }
}
