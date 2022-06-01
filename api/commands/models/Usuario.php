<?php
namespace app\commands\models;
class Usuario_Chat {
    protected $id;
    protected $nombre;
    protected $token;
    public $socket;
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
    }
}
