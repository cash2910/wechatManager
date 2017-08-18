<?php
namespace common\helper;

require_once (dirname(__FILE__) . '/Excel/' . 'PHPExcel.php');
use Yii;
use yii\base\Object;

class ExcelHelp extends Object{

    static $Ins = null;
    public static function getReaderInstance(){
        
        if( self::$Ins == null ){
            self::$Ins = \PHPExcel_IOFactory::createReader('Excel2007');
        }
        return self::$Ins;
        
    }
    
    public static function getWriterInstance( $obj ){
        return \PHPExcel_IOFactory::createWriter( $obj, 'Excel2007');
    }
    
    public static function getPhpExcel(){
        return new \PHPExcel();
    }
    
    
}