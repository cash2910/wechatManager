<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mg_user_rel".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $sub_user_id
 */
class MgUserRel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mg_user_rel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'sub_user_id'], 'required'],
            [['user_id', 'sub_user_id'], 'integer'],
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
        ];
    }
}
