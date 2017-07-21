<?php
namespace common\components\game;

use yii;
use common\service\BaseService;
use common\utils\Curl;

/**
 * 1、获得用户游戏ID
 * http://183.61.243.96:9321/cmd?cmd=op_getuserid&contents={"acc_type":"4","union_id":"oppppppppppppppppppppo","game_id":"13"}
 * 2、加砖石
 * http://183.61.243.96:9321/cmd?cmd=op_diamond&contents={%22uid%22:1000552,%22diamond_num%22:100,%22game_type%22:13}
 * 3、查询砖石
 * http://183.61.243.96:9321/cmd?cmd=op_getuserinfo&uid=1000552&gameid=13
 * @author zaixing.jiang
 */
class Stone extends BaseService{
    
    //获取用户id
    public function getUserId( $union_id ){
        $curl = new Curl();
        $data = [
            'acc_type'=> "4",
            'union_id'=>$union_id,
            'game_id'=>'scmj'
        ];
        $url = yii::$app->params['GAME_URL'].'/cmd?cmd=op_getuserid&contents='. json_encode( $data  );
        $res = $curl->get( $url );
        $ret =  $this->commonParse($res);
        if( 'err' == $ret['status'] )
            throw new \Exception( $ret['msg'] );
        return $ret['result']['uid'];
    }
    
    //添加宝石
    public function addStone( $uid, $num ){
        $curl = new Curl();
        $data = [
            'uid'=>$uid,
            'diamond_num'=>$num,
            'game_type'=>28
        ];
        $url = yii::$app->params['GAME_URL'].'/cmd?cmd=op_diamond&contents='. json_encode( $data  );
        $res = $curl->get( $url );
        yii::error( "添加砖石接口返回信息:{$res}");
        return $this->commonParse( $res );
    }
    
    //获得用户信息接口
    public function getStone(){
        
        $curl = new Curl();
        $data = [
            'uid'=>$uid,
            'diamond_num'=>$num,
            'game_type'=>13
        ];
        $url = yii::$app->params['GAME_URL'].'/cmd?cmd=op_diamond&contents='. json_encode( $data  );
        $res = $curl->get( $url );
        return $this->commonParse($res);
        
    }
    
    
    public  function commonParse( $res ){
        
        $data = [];
        $cols = explode("&", $res);
        foreach( $cols as $k=>$v ){
            list( $n , $c )= explode( "=",  $v );            
            $data[$n] = ( false === strpos($c, "{" ) ) ? $c : json_decode($c, true);
        }
        return $data;
        
    }
    
}

?>