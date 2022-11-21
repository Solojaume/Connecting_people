<?php
namespace app\commands;

use yii\console\Controller;
use Workerman\Worker;
use PHPSocketIO\SocketIO;
//require_once 'C:\xampp\htdocs\connectingpeople\api\vendor\autoload.php';


class SocketIOSustituto extends SocketIO{
    public function __construct($port = null, $opts = array())
    {
        $nsp = isset($opts['nsp']) ? $opts['nsp'] : '\PHPSocketIO\Nsp';
        $this->nsp($nsp);

        $socket = isset($opts['socket']) ? $opts['socket'] : '\PHPSocketIO\Socket';
        $this->socket($socket);

        $adapter = isset($opts['adapter']) ? $opts['adapter'] : '\PHPSocketIO\DefaultAdapter';
        $this->adapter($adapter);
        if(isset($opts['origins']))
        {
            $this->origins($opts['origins']);
        }

        $host=isset($opts['host']) ? $opts['host'] : '0.0.0.0';
        
        $protocol=isset($opts['protocol']) ? $opts['protocol'] : 'SocketIO:';


        unset($opts['nsp'], $opts['socket'], $opts['adapter'], $opts['origins'],$opts["host"],$opts["protocol"]);

        $this->sockets = $this->of('/');

        if(!class_exists('Protocols\SocketIO'))
        {
            class_alias('PHPSocketIO\Engine\Protocols\SocketIO', 'Protocols\SocketIO');
        }
        if($port)
        {
            $worker = new Worker($protocol."//".$host.':'.$port, $opts);
            $worker->name = 'PHPSocketIO';

            if(isset($opts['ssl'])) {
                $worker->transport = 'ssl';
            }

            $this->attach($worker);
        }
    
    }
}