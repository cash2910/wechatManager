<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
            'nickname' => '昵称',
            'sex' => '性别',
            'language' => 'Language',
            'city' => '城市',
            'province' => '省份',
            'country' => 'Country',
            'headimgurl' => '微信头像',
            'subscribe_time' => '订阅时间',
            'unionid' => 'Unionid',
            'remark' => 'Remark',
            'tagid_list' => '用户标签',
        ];
    }
}
