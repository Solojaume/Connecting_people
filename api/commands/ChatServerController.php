<?php
namespace app\commands;

use yii\console\Controller;
use app\commands\models\ChatHandler;
use app\models\Usuario;

class ChatServerController extends Controller
{
   private $socket_working=false;
   public function actionStart($host="localhost",$port = 8080)
   {
      Usuario::DisconectAll();
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
           // echo "Conectaa \n";
            $header = socket_read($newSocket, 1024);
            $chatHandler->doHandshake($header, $newSocket, HOST_NAME, PORT);
    
            socket_getpeername($newSocket, $client_ip_address,$port);
         
            
            //añadimos la nueva conexion a la lista de usuarios
           
            //$connectionACK = $chatHandler->newConnectionACK($client_ip_address);
            
            //$chatHandler->sendAll($connectionACK,$clientSocketArray);
            
            $newSocketIndex = array_search($socketResource, $newSocketArray);
            unset($newSocketArray[$newSocketIndex]);
         }
         
         foreach ($newSocketArray as $newSocketArrayResource) {	
            try {
               while(socket_recv($newSocketArrayResource, $socketData, 1024, 0) >= 1){
                  echo "\nSocket Data";
                            
                  $socketMessage = $chatHandler->unseal($socketData);
                  $messageObj = json_decode($socketMessage);
                  
                  
                  if(isset($messageObj->comand)&& isset($messageObj->objeto)){
                     switch ($messageObj->comand) {
                        case 'auth':
                          
                           echo "\nMensage pre auth";
                           
                           $message = $chatHandler->auth($messageObj->objeto,$newSocketArrayResource);

                           
                          // echo "Mensage2\n";
                        
                           if($message["autenticacion"]==true){
                              echo"\n Autentication True";
                             
                              $connectionACK = $chatHandler->newConnectionACK($message["autenticacion"]["nombre"]);
                              echo "\n NewConnectionACK";
                              $chatHandler->sendAll($connectionACK,$clientSocketArray);
                              echo"\n Send all good";
                              $chatHandler->send($message["message"],$newSocketArrayResource);
                              echo "\n Send";
                           }else{

                              $chatHandler->send($message["message"],$newSocketArrayResource);
                              $this->disconectUser($newSocketArrayResource,$clientSocketArray,$ChatHandler);
                           }
                              
                           break;
                        case 'ge':
                           # code...
                           break;
                        case 'get_chats':
                           $message=CommandsMatchController::getChatsYMatches($messageObj->objeto
                        
                        );                       

                           if($message["autenticacion"]==true){
                              //var_dump($u);
                              $chatHandler->sendAll($message["message"],$clientSocketArray);
                              
                           }else{

                              $chatHandler->sendAll($message["message"],$clientSocketArray);
                              $this->disconectUser($newSocketArrayResource,$clientSocketArray,$ChatHandler);
                           }                          
                           break;
                        case "send":
                           $messageObj=$messageObj->objeto;
                       
                           if(isset($messageObj->chat_user)&&isset($messageObj->chat_message)){
                              echo "find With Token";
                              $messageObj->chat_user=$usuariosHelper->findWithToken($messageObj->chat_user);
                             

                              $messageObj->chat_user=$messageObj->chat_user->nombre;
                             
                              $chat_box_message = $chatHandler->createChatBoxMessage($messageObj->chat_user, $messageObj->chat_message);
                              $chatHandler->sendAll($chat_box_message,$clientSocketArray);
                           }
                           break;
                        case 'desconectar':
                           $m = CommandsUsuarioController::DesconectarPorToken($messageObj->objeto,$chatHandler);
                           $chatHandler->sendAll($m,$clientSocketArray);
                           $this->disconectUser($newSocketArrayResource,$clientSocketArray,$chatHandler);
                           break;
                        default:
                            $chat_message = $chatHandler->$messageObj->comand($messageObj->objeto);
                           // $chatHandler->sendAll($chat_message,$clientSocketArray);
                           break;
                     }
                    
                     //ChatHandler:$messageObj->comand();
                  }
                 
                  
                  break 2;
               }
            } catch (\Throwable $th) {
               //throw $th;
            }
            
            echo"\nsale\n";
            $socketData = @socket_read($newSocketArrayResource, 2048, PHP_NORMAL_READ);
          

            if ($socketData === false) { 
               $this->disconectUser($newSocketArrayResource,$clientSocketArray,$chatHandler);
            }
         }
      }
      socket_close($socketResource);
      echo "Se desconecto";
      Usuario::DisconectAll();
   }
   

   private function disconectUser(&$newSocketArrayResource,&$clientSocketArray,&$chatHandler)
   {
      echo "se desconecta";
      socket_getpeername($newSocketArrayResource, $client_ip_address);
      //socket_close($newSocketArrayResource);
      socket_shutdown($newSocketArrayResource,2);
      $connectionACK = $chatHandler->connectionDisconnectACK("$client_ip_address");
      $chatHandler->sendAll($connectionACK,$clientSocketArray);
      $newSocketIndex = array_search($newSocketArrayResource, $clientSocketArray);
      unset($clientSocketArray[$newSocketIndex]);	  
   
   }
}
