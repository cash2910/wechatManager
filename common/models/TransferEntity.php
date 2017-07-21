<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class TransferEntity extends Model
{
    public $mch_appid = '';
    public $mchid = '';
    public $nonce_str = '';
    public $sign = '';
    public $partner_trade_no;
    public $openid;
    public $check_name;
    public $amount;
    public $desc;
    public $spbill_create_ip;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partner_trade_no', 'openid', 'check_name', 'amount', 'desc','spbill_create_ip'], 'required'],
        ];
    }
}
