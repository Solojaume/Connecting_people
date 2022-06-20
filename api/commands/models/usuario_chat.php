<?php
namespace app\commands\models;
class Usuario_Chat {
    protected $id;
    public $nombre;
    protected $token;
    public $socket;
    private $imagen;
    public function __construct($socket,$id=false,$nombre=false,$token=false) {
        $this->id = $id;
        $this->nombre=$nombre;
        $this->token=$token;
        $this->socket=$socket;
    }
    public function setUsuario($var)
    {
        $this->id=$var["id"];
        $this->nombre=$var["usuario"];
        $this->token=$var["token"];
        return true;
    }

    public function setSocket($soket){
        $this->socket=$socket;
    }
    public function getToken()
    {
        return $this->token;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getId()
    {
       return $this->id;
    }
}
