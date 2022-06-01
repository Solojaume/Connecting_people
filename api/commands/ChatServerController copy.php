<?php
namespace app\commands;

use app\daemons\ChatServer;
use consik\yii2websocket\WebSocketServer;
use yii\console\Controller;
use app\commands\models\ChatHandler;

class ChatServerController extends Controller
{
   private $socket_working=false;
   public function actionStart($host="localhost",$port = 8080)
   {
      $this->socket_working=true;
      define('HOST_NAME',"$host"); 
      define('PORT',$port);
      $null = NULL;
      $chatHandler = new ChatHandler();

      $socketResource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
      socket_set_option($socketResource, SOL_SOCKET, SO_REUSEADDR, 1);
      socket_bind($socketResource, 0, PORT);
      socket_listen($socketResource);
      
      $clientSocketArray = array($socketResource);
      while ($this->socket_working===true) {
         $newSocketArray = $clientSocketArray;
         socket_select($newSocketArray, $null, $null, 0, 10);
         
         if (in_array($socketResource, $newSocketArray)) {
            $newSocket = socket_accept($socketResource);
            $clientSocketArray[] = $newSocket;
            echo "Conectaa \n";
            $header = socket_read($newSocket, 1024);
            $chatHandler->doHandshake($header, $newSocket, HOST_NAME, PORT);
            
            //Sacamos del socket la ip
            socket_getpeername($newSocket, $client_ip_address);
            $connectionACK = $chatHandler->newConnectionACK($client_ip_address);
            
            $chatHandler->sendAll($connectionACK,$clientSocketArray);
            
            $newSocketIndex = array_search($socketResource, $newSocketArray);
            unset($newSocketArray[$newSocketIndex]);
         }
         //var_dump($newSocketArray);
         foreach ($newSocketArray as $newSocketArrayResource) {	
            try {
               while(socket_recv($newSocketArrayResource, $socketData, 1024, 0) >= 1){
                  $socketMessage = $chatHandler->unseal($socketData);
                  $messageObj = json_decode($socketMessage);
                  var_dump($messageObj);
                  if(isset($messageObj->comand)&& isset($messageObj->objeto)){
                     switch ($messageObj->comand) {
                        case 'auth':
                           $message = $chatHandler->auth($messageObj->objeto);
                           if($message["autenticacion"]){
                              $chatHandler->sendAll($message["message"],$clientSocketArray);
                           }else{
                              $chatHandler->sendAll($message["message"],$clientSocketArray);
                           }
                              
                           break;
                        
                        default:
                            $chat_message = $chatHandler->$messageObj->comand($messageObj->objeto);
                           $chatHandler->sendAll($chat_message,$clientSocketArray);
                           break;
                     }
                    
                     //ChatHandler:$messageObj->comand();
                  }
                  if(isset($messageObj->chat_user)&&isset($messageObj->chat_message)){
                     $chat_box_message = $chatHandler->createChatBoxMessage($messageObj->chat_user, $messageObj->chat_message);
                     $chatHandler->sendAll($chat_box_message,$clientSocketArray);
                  }
                  
                  break 2;
               }
            } catch (\Throwable $th) {
               //throw $th;
            }
            
            echo"\nsale\n";
            $socketData = @socket_read($newSocketArrayResource, 1024, PHP_NORMAL_READ);
            var_dump($socketData);
            if ($socketData === false) { 
               $this->disconectUser($newSocketArrayResource,$clientSocketArray,$chatHandler);
            }
         }
      }
      socket_close($socketResource);
      echo "Se desconecto";
   }
   private function findUser(){
      
   }

   private function disconectUser(&$newSocketArrayResource,&$clientSocketArray,&$chatHandler)
   {
      echo "se desconecta";
      socket_getpeername($newSocketArrayResource, $client_ip_address);
      $connectionACK = $chatHandler->connectionDisconnectACK($client_ip_address);
      $chatHandler->sendAll($connectionACK,$clientSocketArray);
      $newSocketIndex = array_search($newSocketArrayResource, $clientSocketArray);
      unset($clientSocketArray[$newSocketIndex]);	  
   
   }
}
