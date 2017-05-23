<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wechat_user_id".
 *
 * @property integer $id
 * @property integer $gid
 * @property string $open_id
 */
class WechatUserId extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wechat_user_id';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gid'], 'integer'],
            [['open_id'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gid' => 'Gid',
            'open_id' => 'Open ID',
        ];
    }
}
