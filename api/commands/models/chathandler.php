<?php
namespace app\commands\models;

use app\commands\CommandsMatchController;
use app\commands\CommandsMensajesController;
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

	function send($message,$clientSocket,$mensaje_db=null)
	{ 
		echo"\nEntrando en send ";
		if(isset($mensaje_db)){
			$mensaje_db->enviado=1;
			$mensaje_db->save();
		}
		$messageLength = strlen($message);
		@socket_write($clientSocket,$message,$messageLength);
		return true;
	}

	function sendToOneByUsuarioId($message,$clientSocketArray,$usuarioId,$token=null,)
	{

		$u=isset($token)?CommandsUsuarioController::getUserWhithAuthToken($token):false;
		if($u && $s=CommandsUsuarioController::findSocketById($clientSocketArray,$usuarioId)){
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

	public function getChatsDeUsuarioBySocket($socket){
		echo "\nEntra en getsCHAT()";
		$u=CommandsUsuarioController::findUsuarioBySocket($socket);
		$getChatYMatches=CommandsMatchController::getChatsYMatchesById($u->id);	
		
		echo "\nObtenido los matches";
		echo"\nIsset Matches: ";	
		var_dump(  isset($getChatYMatches["Matches"]));
		echo "\n \nIsset Chats: ";
		var_dump(isset($getChatYMatches["Chats"]));
		echo"\n\n Autenticacion: ";
		var_dump($getChatYMatches["Autenticacion"]);
		echo"\n\n Condicion If: ";
		var_dump($getChatYMatches["Autenticacion"] && isset($getChatYMatches["Matches"])&&isset($getChatYMatches["Chats"]));
		if($getChatYMatches["Autenticacion"] && isset($getChatYMatches["Matches"])&&isset($getChatYMatches["Chats"])){
			echo "\nEntra en el ifo";
			$ChatYMatches=["Matches"=>$getChatYMatches["Matches"],"Chats"=>$getChatYMatches["Chats"]];
			$message=$this->seal(json_encode(["chat_user"=>"system",'chat_message'=>$ChatYMatches,'message_type'=>'chats']));
			//echo "MENSaje";
			return ["autenticacion"=>TRUE,"message"=>$message];
		}else{
			echo "\nUps dentro de elsa";
			$message=$this->seal(json_encode(array("chat_user"=>"system",'chat_message'=>"Error, por favor inicie sesion de nuevo",'message_type'=>'auth_error')));
			return ["autenticacion"=>FALSE,"message"=>$message];
		} 
	}

	/*
	*Este metodo sirve para obtener los chats de un usuario con su token  */
	public function getChatsDeUsuario($token){
		echo "\nEntra en getsCHAT()";
		$getChatYMatches=CommandsMatchController::getChatsYMatches($token);	
		
		echo "\nObtenido los matches";
		echo"\nIsset Matches: ";	
		var_dump(  isset($getChatYMatches["Matches"]));
		echo "\n \nIsset Chats: ";
		var_dump(isset($getChatYMatches["Chats"]));
		echo"\n\n Autenticacion: ";
		var_dump($getChatYMatches["Autenticacion"]);
		echo"\n\n Condicion If: ";
		var_dump($getChatYMatches["Autenticacion"] && isset($getChatYMatches["Matches"])&&isset($getChatYMatches["Chats"]));
		if($getChatYMatches["Autenticacion"] && isset($getChatYMatches["Matches"])&&isset($getChatYMatches["Chats"])){
			echo "\nEntra en el ifo";
			$ChatYMatches=["Matches"=>$getChatYMatches["Matches"],"Chats"=>$getChatYMatches["Chats"]];
			echo"\nPost $ ChatYMatch";
			$message=$this->seal(json_encode(["chat_user"=>"system",'chat_message'=>$ChatYMatches,'message_type'=>'chats']));
			//echo "MENSaje";
			return ["autenticacion"=>TRUE,"message"=>$message];
		}else{
			echo "\nUps dentro de elsa";
			$message=$this->seal(json_encode(array("chat_user"=>"system",'chat_message'=>"Error, por favor inicie sesion de nuevo",'message_type'=>'auth_error')));
			return ["autenticacion"=>FALSE,"message"=>$message];
		} 
	}

	public function cambiadaPagina($token,&$socket=null)
	{
		echo "\nleer ip servidor";
		//Obtenemos la ip local y su puerto
		socket_getpeername($socket,$ip_s,$p_s);
		echo "IP: $ip_s , Puerto: $p_s";
		echo "\npre leer socket ip cliente";
		//Obtenemos ip remota y su puerto
		socket_getpeername($socket,$ip_c, $p_c);
		
		echo "\nPre auth cambiada";
		$u=CommandsUsuarioController::auth($token,$ip_c,$p_c,$ip_s,$p_s);
		echo "\n Auth cAMBIADA PAGINA";
		
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

	/*
	*Este metodo recive, guarda y prepara el mensaje para ser enviado al usuario2, ademas de comprovar tambien si el usuario  esta autenticado o no
	
	*/
	public function getMensajeParaUsuario2($objeto)
	{   var_dump($objeto);
		echo "\ngetMensajeParaUsuario2";
		$findUsuario2ByMaResult=CommandsMatchController::findUsuario2ByMatch($objeto->chat_user,$objeto->match_id);
		echo "\nfindUsuario2ByMaResult correcto";
		$message=["chat_user"=>"system",'chat_message'=>"Error, por favor inicie sesion de nuevo",'message_type'=>'auth_error'];
		if($findUsuario2ByMaResult["autenticacion"]==false){
			echo"\nEntra en el if";
			$message=$this->seal(json_encode($message));
			return ["autenticacion"=>false,"message"=>$message];
		}
		$u=$findUsuario2ByMaResult["autenticacion"];
		//Asignamos los datos a la variable a devolver;
		//Asignamos los datos a la variable a devolver;
		$objeto->chat_user = $u->id;
		$message["chat_user"] = ["id"=>$u->id,"nombre"=>$u->nombre,"edad"=>$u->timestamp_nacimiento];
		$message["chat_message"] = $objeto->chat_message;
		$message["message_type"]="mensaje";
		$message["match_id"]=$objeto->match_id;
		echo "\n Pre crea Mensaje bd";
		$findUsuario2ByMaResult["mensaje_bd"]=CommandsMensajesController::create($objeto);
		echo "\n Se ha creado  el mensaje en bd";
		$message["id"]=$findUsuario2ByMaResult["mensaje_bd"]->mensajes_id;
		$message_devolver=$this->seal(json_encode($message));
		
		unset($message);
		$findUsuario2ByMaResult["mensajes_devolver"]=$message_devolver;
		
		
		//$match["id"]=
		return $findUsuario2ByMaResult;
		
	}
}


?> 