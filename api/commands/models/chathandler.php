<?php
namespace app\commands\models;

use app\commands\CommandsMatchController;
use app\commands\CommandsUsuarioController;
use app\models\Mach;
use app\models\Usuario;

use app\models\Mensajes;

class ChatHandler {
	//En la siguiente variable guardo una concurrencia por cada usuario 
	private $chat_rooms=[];
	function sendAll($message,$clientSocketArray) {
		$messageLength = strlen($message);
		echo ("\nSend all");
		foreach($clientSocketArray as $clientSocket)
		{
 			@socket_write($clientSocket,$message,$messageLength);
		}
		return true;
	}

	function send($message,$clientSocket)
	{
		$messageLength = strlen($message);
		@socket_write($clientSocket,$message,$messageLength);
		return true;
	}

	function sendToOneByUsuarioId($message,$clientSocketArray,$usuarioId)
	{
		if($s=CommandsUsuarioController::findSocketById($clientSocketArray,$usuarioId)){
			$this->send($message,$s);
			return true;
		}
		return false;
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
		//echo("new ACK \n");
		//var_dump($client_ip_address);
		echo "\n ACK";
		$message = 'New client ' . $client_ip_address;
		echo "\n New ACK POR DEntro";
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
	
	/*
	* Este es el metodo que autentifica
	*/
	public function auth($token,&$socket=null)
	{
		
		//Obtenemos ip remota y su puerto
		socket_getpeername($socket,$ip_c, $p_c);

		//Obtenemos la ip local y su puerto
		socket_getpeername($socket,$ip_s,$p_s);
		$u=CommandsUsuarioController::auth($token,$ip_c,$p_c,$ip_s,$p_s);
		echo "\n Auth ";
		
		if(isset($u->id)&&isset($u->nombre)&&isset($u->token)){
			$u=["id"=>$u->id,"nombre"=>$u->nombre,"token"=>$u->token,"rol"=>0];
			$message=$this->seal(json_encode(["chat_user"=>"system",'chat_message'=>"Auth correcta",'message_type'=>'auth']));
			//return $message;
			return ["autenticacion"=>$u,"message"=>$message];
		}else{
			$message=$this->seal(json_encode(array("chat_user"=>"system",'chat_message'=>"Error, por favor inicie sesion de nuevo",'message_type'=>'auth_error')));
			return ["autenticacion"=>FALSE,"message"=>$message];
        }

	}


	public function getChatsDeUsuario($token){
		echo "Entra en getsCHAT()";
		$getChatYMatches=CommandsMatchController::getChatsYMatches($token);		
		if($getChatYMatches["autenticacion"] && isset($getChatYMatches["Matches"])&&isset($getChatYMatches["Chats"])){
			$ChatYMatches=["Matches"=>$getChatYMatches["Matches"],"Chats"=>$getChatYMatches["Chats"]];
			$message=$this->seal(json_encode(["chat_user"=>"system",'chat_message'=>$ChatYMatches,'message_type'=>'chats']));
			//echo "MENSaje";
			return ["autenticacion"=>TRUE,"message"=>$message];
		}else{
			$message=$this->seal(json_encode(array("chat_user"=>"system",'chat_message'=>"Error, por favor inicie sesion de nuevo",'message_type'=>'auth_error')));
			return ["autenticacion"=>FALSE,"message"=>$message];
		} 
	}

	public function cambiadaPagina($token,&$socket=null)
	{
		
		//Obtenemos ip remota y su puerto
		socket_getpeername($socket,$ip_c, $p_c);

		//Obtenemos la ip local y su puerto
		socket_getpeername($socket,$ip_s,$p_s);
		$u=CommandsUsuarioController::auth($token,$ip_c,$p_c,$ip_s,$p_s);
		echo "\n Auth ";
		
		if(isset($u->id)&&isset($u->nombre)&&isset($u->token)){
			$u=["id"=>$u->id,"nombre"=>$u->nombre,"token"=>$u->token,"rol"=>0];
			$message=$this->seal(json_encode(["chat_user"=>"system",'chat_message'=>"Cambiado Pagina Correctamente",'message_type'=>'CambiadaPagina']));
			//return $message;
			return ["autenticacion"=>$u,"message"=>$message];
		}else{
			$message=$this->seal(json_encode(array("chat_user"=>"system",'chat_message'=>"Error, por favor inicie sesion de nuevo",'message_type'=>'auth_error')));
			return ["autenticacion"=>FALSE,"message"=>$message];
        }

	}

	
}


?> 