<?php
namespace app\commands\models;
class Chat_Rooms{
    //EsTE ES EL IDENTIFICADOR UNICO POR CADA CONCURRECIA DEL MATCH 
   
    private $chat_room_id;
    private $match_id;
    private $usuario_1;
    private $usuario_2;
    private $estado;
    private $mensajes;
    
    public function __construct( $chat_room_id = null,$match_id=null, $usuario_1 = [], $usuario_2 = [], $estado = "Off line", $mensajes=[]) {
       
        $this->chat_room_id = $chat_room_id;
        $this->match_id =$match_id;
        $this->usuario_1 = $usuario_1;
        $this->usuario_2 = $usuario_2;
        $this->estado = $estado;
        $this->mensajes = $mensajes;
    }
    /*
    public function __construct( $chat_room_id = null, $match_id=null, $usuario_1=[], $usuario_2 = [], $estado = null, $mensajes = []) {
        //echo "Cons new Chat";
        $this->chat_room_id=$chat_room_id;
        $this->match_id=$match_id;
        $this->usuario_1=$usuario_1;
        $this->usuario_2=$usuario_2;
        $this->$estado=$estado;
        $this->$mensajes=$mensajes;
    }*/
    //Getters
    public  function get_chat_room_id()
    {
        return $this->chat_room_id;
    }

    public function get_match_id()
    {
        return $this->match_id;
    }

    public function get_usuario_1()
    {
        return $this->usuario_1;
    }

    public function get_usuario_2()
    {
        return $this->usuario_2;
    }
    public function get_estado()
    {
        return $this->estado;
    }

    public function get_mensajes()
    {
        return $this->mensajes;
    }

    public function asArray()
    {
        /*$var=[];
        foreach ($this as $key => $value) {
            $var["$key"]=$value;
        }
        return $var;*/
        echo "asARRAY";
       return [
        "chat_room_id"=>$this->chat_room_id,
        "match_id"=>$this->match_id,
        "usuario_1"=>$this->usuario_1,
        "usuario_2"=>$this->usuario_2,
        "estado"=>$this->estado,
        "mensajes"=>$this->mensajes
        ];
    }


    //SETTER
    public function set_estado($estado){
        $this->estado=$estado;
    }

    public function set_mensajes($mensajes)
    {
        $this->mensajes=$mensajes;
    }

}