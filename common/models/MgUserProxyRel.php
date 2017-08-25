<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mg_user_proxy_rel".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $sub_user_id
 * @property string $user_openid
 * @property string $sub_user_openid
 */
class MgUserProxyRel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_user_proxy_rel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'sub_user_id'], 'required'],
            [['user_id', 'sub_user_id'], 'integer'],
            [['user_openid', 'sub_user_openid'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'sub_user_id' => 'Sub User ID',
            'user_openid' => 'User Openid',
            'sub_user_openid' => 'Sub User Openid',
        ];
    }
}
