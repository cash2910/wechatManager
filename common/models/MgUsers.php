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
 * @property integer $proxy_pid
 * @property string $user_proxy_rels
 * @property string $rebate_ratio
 * @property integer $user_role
 */
class MgUsers extends \yii\db\ActiveRecord
{
    //订阅状态
    const IS_SUBSCRIPT = 1;
    const NOT_SUBSCRIPT = 2;
    
    const IS_BD = 1;
    const IS_PLAYER = 0;
    
    //角色状态
    const PLAYER_USER = 0;
    const MANAGER_USER = 1;
    const BD_USER = 2;
    
    static public $role_desc=[
        self::PLAYER_USER     =>'玩家',
        self::MANAGER_USER =>'管理员',
        self::BD_USER =>'推广员',
    ];
    
    static public $role_msg=[
        self::IS_BD     =>'代理',
        self::IS_PLAYER =>'普通玩家',
    ];
    
    static public $status_msg=[
        self::IS_SUBSCRIPT =>'已关注',
        self::NOT_SUBSCRIPT=>'未关注',
    ];
    
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
            [['status', 'is_bd', 'register_time', 'update_time','proxy_pid','user_role'], 'integer'],
            [['nickname'], 'string', 'max' => 30],
            [['rebate_ratio'],'number','max'=>100],
            [['user_rels','user_proxy_rels'],'string','max'=>150],
            [['user_logo'],'string','max'=>200],
            [['open_id','union_id'], 'string', 'max' => 60],
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
            'nickname' => '用户昵称',
            'status' => '状态',
            'open_id' => 'Open ID',
            'passwd' => '密码',
            'is_bd' => '是否为推广员',
            'mobile' => '手机号',
            'register_time' => '注册时间',
            'update_time' => '更新时间',
            'user_rels' => '好友层级',
            'proxy_pid'=>'上级代理Id',
            'user_proxy_rels' => '代理层级',
            'rebate_ratio' => '返利比例',
            'user_role' => '用户类型'
        ];
    }
}
