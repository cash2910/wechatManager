<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wechat_cs".
 *
 * @property integer $id
 * @property string $kf_account
 * @property string $kf_nick
 * @property integer $kf_id
 * @property string $kf_headimgurl
 * @property string $kf_wx
 * @property string $invite_wx
 * @property string $invite_status
 */
class WechatCs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_cs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kf_id'], 'integer'],
            [['kf_account', 'kf_wx', 'invite_wx'], 'string', 'max' => 60],
            [['kf_nick', 'invite_status'], 'string', 'max' => 30],
            [['kf_headimgurl'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kf_account' => '客服帐号',
            'kf_nick' => '客服昵称',
            'kf_id' => '客服编号',
            'kf_headimgurl' => '客服头像',
            'kf_wx' => 'Kf Wx',
            'invite_wx' => 'Invite Wx',
            'invite_status' => 'Invite Status',
        ];
    }
}
