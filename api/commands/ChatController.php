<?php
namespace app\commands;

use stdClass;
use yii\console\Controller;
use Workerman\Worker;
require_once 'C:\xampp1\htdocs\connectingpeople\api\vendor\autoload.php';


class ChatController extends Controller{
    public function actionStart($host="127.0.0.1",$port = 3000,$protocol=null){
        $io = new SocketIOSustituto($port,
        [
            "host"=>$host
        ]);
        
        $GLOBALS["usocket"] = [];
        $GLOBALS["users"] = [];       
        $io->on('connection', function ($socket) {
            $socket->addedUser = false;
           
            
            // When the client emits 'add user', this listens and executes
            $socket->on('new user', function ($username) use ($socket) {
                echo "\n Nuevo usuario";
                $socket->addedUser = true;
                //global $usocket,$user ;
                $usocket=&$GLOBALS["usocket"];
                $users=&$GLOBALS["users"];
                if(!in_array($username,$usocket)) {
                    // We store the username in the socket session for this client
                    $socket->username = $username;
                    // Add the client's socket to the user list
                    $usocket[$username] = $socket;
                    $users[] = $username;
                    $socket->emit('login',$users);
                    // echo globally (all clients) that a person has connected
                    $socket->broadcast->emit('user joined',$username,(count($users)-1));
                    echo"\n Users:";
                    var_dump($users);
                    echo"\n Usocket:";
                    //var_dump($usocket);
                }
               
            });
        
            // When the client emits 'typing', we broadcast it to others
            $socket->on('typing', function () use ($socket) {
                $socket->broadcast->emit('typing', array(
                    'username' => $socket->username
                ));
            });
        
            // When the client emits 'stop typing', we broadcast it to others
            $socket->on('stop typing', function () use ($socket) {
                $socket->broadcast->emit('stop typing', array(
                    'username' => $socket->username
                ));
            });
        
            // When the client emits 'new message', this listens and executes
            $socket->on('send private message', function($res){
                echo "\n\n\n ENTRA EN SEND";
                $usocket=&$GLOBALS["usocket"];
                $users=&$GLOBALS["users"];
                echo"\n Mensajes:";
                var_dump($res);
                echo "Users en 'Send private message':";
                var_dump($users);
                echo"\nUsocket[res['recipient']]:";
                //var_dump($usocket[$res["recipient"]]);
                echo"\n self::in_array:";
                var_dump(self::in_array($usocket,$res["recipient"]));
             
                if(self::in_array($usocket,$res["recipient"])) {
                    echo "\nDentro del if de send";
                    $usocket[$res["recipient"]]->emit('receive private message', $res);
                }
                echo "\n¡¡¡SALE DE SEND!!!\n\n\n";
            });
            
            // When the user disconnects, perform this
            $socket->on('disconnect', function($data)use($socket){
                //Desconectar usuario
                $usocket=&$GLOBALS["usocket"];
                $users=&$GLOBALS["users"];
                echo"\nDesconectar Usuario:";
                //var_dump($socket);
                echo"\n SOCKET->username:";
                var_dump($socket->username);

                echo"\nIn array:";
                var_dump(self::in_array($usocket,$socket->username));
                if(self::in_array($usocket,$socket->username)){
                    echo"\n Entra en el if";
                    unset($usocket[$socket->username]);
                    array_splice($users,array_search($socket->username,$users),count($users)-1);
                    //unset($users[strrpos($users,$socket->username)]);
                    //$users->splice($users->indexOf($socket->username), 1);
                }
                echo"\n Users deleted:";
                var_dump($users);
                $socket->broadcast->emit('user left',$socket->username);
            });
            
            
         
        });
        
        Worker::runAll();
    }

    public static function in_array($array,$object)
    {
        foreach ($array as $key=>$value ) {
            if($key==$object){
                return true;
            }
        }
        return false;
    }
}