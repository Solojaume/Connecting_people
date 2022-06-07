<?php
namespace app\commands\models;

use app\commads\models\Usuario1 as ModelsUsuario1;
use app\controllers\UsuarioController;
use app\models\Mach;
use app\models\Usuario;
require_once("chat_Rooms.php");
use app\commands\models\Chat_Rooms;
use app\models\Mensajes;

class ChatHandler {
	//En la siguiente variable guardo una concurrencia por cada usuario 
	private $chat_rooms=[];
	function sendAll($message,$clientSocketArray) {
		$messageLength = strlen($message);
		echo ("send \n");
		foreach($clientSocketArray as $clientSocket)
		{
 			@socket_write($clientSocket,$message,$messageLength);
		}
		return true;
	}

	function unseal($socketData) {
		$length = ord($socketData[1]) & 127;
		if($length == 126) {
			$masks = substr($socketData, 4, 4);
			$data = substr($socketData, 8);
		}
		elseif($length == 127) {
			$masks = substr($socketData, 10, 4);
			$data = substr($socketData, 14);
		}
		else {
			$masks = substr($socketData, 2, 4);
			$data = substr($socketData, 6);
		}
		$socketData = "";
		for ($i = 0; $i < strlen($data); ++$i) {
			$socketData .= $data[$i] ^ $masks[$i%4];
		}
		return $socketData;
	}

	function seal($socketData) {
		$b1 = 0x80 | (0x1 & 0x0f);
		$length = strlen($socketData);
		
		if($length <= 125)
			$header = pack('CC', $b1, $length);
		elseif($length > 125 && $length < 65536)
			$header = pack('CCn', $b1, 126, $length);
		elseif($length >= 65536)
			$header = pack('CCNN', $b1, 127, $length);
		return $header.$socketData;
	}

	function doHandshake($received_header,$client_socket_resource, $host_name, $port) {
		$headers = array();
		$lines = preg_split("/\r\n/", $received_header);
		foreach($lines as $line)
		{
			$line = chop($line);
			if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
			{
				$headers[$matches[1]] = $matches[2];
			}
		}

		$secKey = $headers['Sec-WebSocket-Key'];
		$secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
		$buffer  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
		"Upgrade: websocket\r\n" .
		"Connection: Upgrade\r\n" .
		"WebSocket-Origin: $host_name\r\n" .
		"WebSocket-Location: ws://$host_name:$port/demo/shout.php\r\n".
		"Sec-WebSocket-Accept:$secAccept\r\n\r\n";
		socket_write($client_socket_resource,$buffer,strlen($buffer));
	}
	
	function newConnectionACK($client_ip_address) {
		echo("new ACK \n");
		$message = 'New client ' . $client_ip_address;
		$messageArray = array("chat_user"=>"system",'chat_message'=>$message,'message_type'=>'chat-connection-ack');
		$ACK = $this->seal(json_encode($messageArray));
		return $ACK;
	}
	
	function connectionDisconnectACK($client_ip_address) {
		$message = 'Client ' . $client_ip_address;
		$messageArray = array("chat_user"=>"system",'chat_message'=>$message,'message_type'=>'chat-connection-ack');
		$ACK = $this->seal(json_encode($messageArray));
		return $ACK;
	}
	
	public function createChatBoxMessage($chat_user,$chat_box_message) {
		$messageArray = array("chat_user"=>"$chat_user",'chat_message'=>$chat_box_message,'message_type'=>'chat-message');
		$chatMessage = $this->seal(json_encode($messageArray));
		return $chatMessage;
	}
	
	public function auth($token,&$usuariosHelper,$socket){
		$token_auth =$token;
		
        $u=Usuario::findIdentityByAccessToken($token_auth);
		
        $con=$u->token==$token;
        $con2=$u->validateCaducityDateAuthToken()==true;
       
        if($con && $con2){
            $u = ["usuario"=>$u->nombre,"token"=>$token_auth,"id"=>$u->id];
        }
		
		if(isset($u["id"])&&isset($u["usuario"])&&isset($u["token"])){
			//En esta variable se guardan los matches sacados de la bd
			$matchs=Mach::getUserMatches($u["id"]);
			//La siguiente variable existe para solo enviarle
			$matches=[];
			echo "entra en auth\n";
			foreach ($matchs as $key ) {
				echo"foreach salvage";
				if($key["match_id_usu1"]==$u["id"]){
					echo "\nDentro del ifo";
					$usuario1=Usuario::findIdentity($u["id"]);
					$usuario2=Usuario::findIdentity($key["match_id_usu2"]);

					$chat_room_id=uniqid();
					$estado="Off line";
					$mensages_devolver=[];
					if($usuariosHelper->findWithId($key["match_id_usu2"])==true){
						echo "On lINE\n";
						$estado="On Line";
					}
					$mensages_bd=Mensajes::getMensajesByMatch($key["match_id"])??[];
					foreach ($mensages_bd as $mensage ) {
						$mensage_devolver=$mensage;
						echo "\ndentro del for ifado";
						$mensage_devolver[]=[
							
							"chat_room_id"=>$chat_room_id
						];
						$mensages_devolver[]=$mensage_devolver;
					}
					$matches[] = new Chat_Rooms(
						//"chat_room_id"
						$chat_room_id,
						//"match_id"
						$key["match_id"],
						//"usuario_1"=>
						[//EsTE SIEMPRE HACE REFENCIA AL USUARIO QUE SE AUTENTICA
							"id"=>$usuario1["id"],
							"nombre"=>$usuario1["nombre"]
						],
						//"usuario_2"
						[
							"id"=>$usuario2["id"],
							"nombre"=>$usuario2["nombre"]
						],
						//estado"
						$estado,
						//"mensajes"
						$mensages_devolver
					);

				}else if($key["match_id_usu2"]==$u["id"]){
					echo "\n Dentro de elsa\n";
					$usuario1=Usuario::findIdentity($key["match_id_usu2"]);
					$usuario2=Usuario::findIdentity($key["match_id_usu1"]);

					$chat_room_id=uniqid();
					$estado="Off line";
					$mensages_devolver=[];
					//var_dump($usuariosHelper->findWithId($key["match_id_usu1"]));
					echo "match_id_usu1";
					if($usuariosHelper->findWithId($key["match_id_usu1"])==true){
						echo "Online 2";
						$estado="On Line";
					}
					$mensages_bd=Mensajes::getMensajesByMatch($key["match_id"])??[];
					echo"\nAntes del for";
					foreach ($mensages_bd as $key2 ) {
						echo "\ndentro del for elsado";
						$mensage_devolver=$key2;
						$mensage_devolver[]=[
							"chat_room_id"=>$chat_room_id
						];
						$mensages_devolver[]=$mensage_devolver;
					}
					echo "\nNew CHAT";
					/*$matches[]=new Chat_Rooms(
						//"chat_room_id"
						$chat_room_id,
						//"match_id"
						$key["match_id"],
						//"usuario_1"=>
						[//EsTE SIEMPRE HACE REFENCIA AL USUARIO QUE SE AUTENTICA
							"id"=>$usuario1["id"],
							"nombre"=>$usuario1["nombre"]
						],
						//"usuario_2"
						[
							"id"=>$usuario2["id"],
							"nombre"=>$usuario2["nombre"]
						],
						//estado"
						$estado,
						//"mensajes"
						$mensages_devolver
					);*/
					
					$matches[]=new Chat_Rooms(
						$chat_room_id,$key["match_id"],
						[//EsTE SIEMPRE HACE REFENCIA AL USUARIO QUE SE AUTENTICA
							"id"=>$usuario1["id"],
							"nombre"=>$usuario1["nombre"]
						],
						[
							"id"=>$usuario2["id"],
							"nombre"=>$usuario2["nombre"]
						],
						$estado, 
						$mensages_devolver
					);
					echo"\nestoY A MEDIA";
				}
				
			}
			$matches_devolver=[];
			echo"\nestoy ya \n";
			foreach ($matches as $key ) {
				$this->chat_rooms[]= $key;
				$matches_devolver[]=$key->asArray();
			}
			
			$message=$this->seal(json_encode(["chat_user"=>"system",'chat_message'=>$matches_devolver,'message_type'=>'auth']));
			//return $message;
			return ["autenticacion"=>["usuario"=>$u["usuario"],"token"=>$u["token"],"id"=>$u["id"]],"message"=>$message];
		}else{
			$message=$this->seal(json_encode(array("chat_user"=>"system",'chat_message'=>"error",'message_type'=>'auth_error')));
			return ["autenticacion"=>false,"message"=>$message];
		} 
	}
	
}

?>