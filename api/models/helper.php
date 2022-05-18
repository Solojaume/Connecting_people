<?php
namespace app\models;

use DateTime;
use Yii;

/**
 * This is the model class for table "mach".
 *
 * @property int $match_id
 * @property int $match_id_usu1
 * @property int $match_id_usu2
 * @property int $match_estado_u1
 * @property int $match_estado_u2
 * @property string $match_fecha
 *
 * @property Usuario $matchIdUsu1
 * @property Usuario $matchIdUsu2
 * @property Mensajes[] $mensajes
 * @property Reporte[] $reportes
 */
class Helper{
    public static function calcularEdad($nacimiento){
        $nacimiento = strtotime($nacimiento);
        $now=time();
        $result=($now - $nacimiento)/((365*24*60*60)+0.25);
        return round($result);
    }
}
