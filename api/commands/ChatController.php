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
        
        
        
        
        $io->on('connection', function ($socket) {
            $socket->addedUser = false;
            $GLOBALS["usocket"] = [];
            $GLOBALS["users"] = [];
            

            // When the client emits 'new message', this listens and executes
            $socket->on('send private message', function ($data) use ($socket) {
                var_dump($socket);
                // We tell the client to execute 'new message'
                $socket->broadcast->emit('new message', array(
                    'username' => $socket->username,
                    'message' => $data
                ));
            });
           
         
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
        
            // When the user disconnects, perform this
            $socket->on('disconnect', function()use($socket){
                //Desconectar usuario
                $usocket=&$GLOBALS["usocket"];
                $users=&$GLOBALS["users"];
                if(in_array($socket->username,$usocket)){
                    unset($usocket[$socket->username]);
                    $users->splice($users->indexOf($socket->username), 1);
                }
                var_dump($users);
                $socket->broadcast->emit('user left',$socket->username);
            });
        });
        
        Worker::runAll();
    }
}