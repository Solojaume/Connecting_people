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
            echo("\n\n\n\n\n Nuevo usuario conectado");
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
                              echo"\nMessage";
                              var_dump($message["message"]);
                              $chatHandler->send($message["message"],$newSocketArrayResource);
                              echo "\n Sended";
                           }else{

                              $chatHandler->send($message["message"],$newSocketArrayResource);
                              $this->disconectUser($newSocketArrayResource,$clientSocketArray,$ChatHandler);
                           }
                              
                           break;
                        case 'cambiar_pagina':
                           $this->disconectUser($newSocketArrayResource,$clientSocketArray,$ChatHandler,false);
                           break;
                        case 'cambiada_pagina':
                           echo"\nCambiada PAGINA";
                           $message = $chatHandler->cambiadaPagina($messageObj->objeto,$newSocketArrayResource);
                           echo"mensaje";
                           var_dump($message);
                           $chatHandler->send($message["message"],$newSocketArrayResource);
                           break;
                        case 'get_chats':
                           echo "\nGet chats";
                           $message = $chatHandler->getChatsDeUsuario($messageObj->objeto);                       

                           if($message["autenticacion"]==true){
                              //var_dump($u);
                             // $chatHandler->sendAll($message["message"],$clientSocketArray);
                              $chatHandler->send($message["message"],$newSocketArrayResource);
                              
                           }else{

                              $chatHandler->sendAll($message["message"],$clientSocketArray);
                              $this->disconectUser($newSocketArrayResource,$clientSocketArray,$ChatHandler);
                           }                          
                           break;
                        case "send":
                           echo "\n send switch";
                           $messageObj=$messageObj->objeto;
                       
                           if(isset($messageObj->chat_user)&&isset($messageObj->chat_message)){
                             
                              echo "\nPRERespuesta";
                              $respuesta=$chatHandler->getMensajeParaUsuario2($messageObj);
                            
                              echo"\nClientSocketAray:";
                              var_dump($clientSocketArray);
                              echo "\nPost getMensajeParaUsuario2";
                              echo"\nPreFindUsuarioBySocket";
                              
                              //$socket_u2=CommandsUsuarioController::findSocketByUsuario($clientSocketArray,$respuesta["usuario2"],$newSocketArray);
                              //echo "\nPost GetsocketByUsuario";
                             // echo "\nVer respuesta:";
                              //var_dump($respuesta);
                              
                              echo "\n Var dump mensaje_devolver:";
                              var_dump($respuesta["mensajes_devolver"]);
                              echo "\n Presend";
                              $chatHandler->send($respuesta["mensajes_devolver"],$newSocketArrayResource);
                              echo "\nPost Send al usuario que lo envio\n";
                              var_dump($respuesta["autenticacion"]==false);
                              if($respuesta["autenticacion"]==false){
                                 $this->disconectUser($newSocketArrayResource,$clientSocketArray,$ChatHandler,false);
                              }
                              echo "\nEstado 2";
                              var_dump($respuesta["estado2"]);

                              if($respuesta["estado2"]=="Conectado"||$respuesta["estado2"]=="Escriviendo"){
                                 //var_dump($socket_u2);
                                 echo "\Presend Send al usuario que lo recivio";
                                 //$chatHandler->send($respuesta["mensajes_devolver"],$socket_u2,$respuesta["mensajes_db"]);
                                 echo "\nPost Send al usuario que lo recivio";
                              }
                              
                              echo"\nNo entra en el if";
                           
                           }
                           break;
                        case 'desconectar':
                           echo "\n Desconectar por token";
                           $m = CommandsUsuarioController::DesconectarPorToken($messageObj->objeto,$chatHandler);
                           $chatHandler->send($m,$newSocketArrayResource);
                           $this->disconectUser($newSocketArrayResource,$clientSocketArray,$chatHandler);
                           break;
                        default:
                            $chat_message = $chatHandler->$messageObj->comand($messageObj->objeto);
                           // $chatHandler->sendAll($chat_message,$clientSocketArray);
                           break;
                     }
                   
                     //ChatHandler:$messageObj->comand();
                  }
                 
                  //$u=CommandsUsuarioController::findUsuarioBySocket($newSocketArrayResource);
                  $reauth=$chatHandler->newReAuth();
                  $chatHandler->send($reauth,$newSocketArrayResource); 
                  echo"\n Sended reauth";
                  break 2;
               }
            } catch (\Throwable $th) {
               //throw $th;
            }
            
            
         
            echo"\nsale\n";
            $socketData = @socket_read($newSocketArrayResource, 2048, PHP_NORMAL_READ);
          
           
            if ($socketData === false) { 
               var_dump($newSocketArrayResource);
               $this->disconectUser($newSocketArrayResource,$clientSocketArray,$chatHandler);
            } 
            
         }
      }
      socket_close($socketResource);
      echo "Se desconecto";
      Usuario::DisconectAll();
   }
   

   private function disconectUser(&$newSocketArrayResource,&$clientSocketArray,&$chatHandler, $enviarMensajeATodos=true)
   {
      echo "\nSe desconecta el usuario";
      socket_getpeername($newSocketArrayResource, $client_ip_address);
      //socket_close($newSocketArrayResource);
      socket_shutdown($newSocketArrayResource,2);
      $connectionACK = $chatHandler->connectionDisconnectACK("$client_ip_address");
      if($enviarMensajeATodos==true)
         $chatHandler->sendAll($connectionACK,$clientSocketArray);
      $newSocketIndex = array_search($newSocketArrayResource, $clientSocketArray);
      unset($clientSocketArray[$newSocketIndex]);	  
   
   }
}
