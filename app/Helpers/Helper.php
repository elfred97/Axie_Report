<?php
namespace App\Helpers;

class Helper
{

    public static function IDGenerator($model,$prefix){
        $maxTrans = (count($model::GET()) > 0) ? $model::max('id') : 0;
        $maxTrans += 1;
        $numberFormatted = sprintf('%04d',$maxTrans);
        return $prefix.'-'.$numberFormatted;
    }
  
}
?>