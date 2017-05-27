<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wechat_users".
 *
 * @property integer $id
 * @property string $open_id
 * @property string $nick_name
 * @property integer $sex
 * @property string $language
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $headimgurl
 * @property string $subscribe_time
 * @property string $unionid
 * @property string $remark
 * @property string $tagid_list
 */
class WechatUsers extends \yii\db\ActiveRecord
{
    
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'register_time',
                'updatedAtAttribute' => 'update_time',
                'value'   => function(){return date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']);},
            ],
       ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'subscribe_time'], 'integer'],
            [['open_id', 'unionid'], 'string', 'max' => 60],
            [['nickname'], 'string', 'max' => 20],
            [['language', 'city', 'province', 'country'], 'string', 'max' => 10],
            [['headimgurl'], 'string', 'max' => 200],
            [['remark', 'tagid_list'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'open_id' => 'Open ID',
            'nickname' => 'NickName',
            'sex' => 'Sex',
            'language' => 'Language',
            'city' => 'City',
            'province' => 'Province',
            'country' => 'Country',
            'headimgurl' => 'Headimgurl',
            'subscribe_time' => 'Subscribe Time',
            'unionid' => 'Unionid',
            'remark' => 'Remark',
            'tagid_list' => 'Tagid List',
        ];
    }
}
