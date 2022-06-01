<?php
namespace app\commands\models;

use app\commands\models\Usuario_Chat;

class UsuarioHelper{
    private $usuarios;
    
    public function __construct() {
       $usuarios=[];
    }

    public function addUsuario($socket)
    {
        $this->usuarios[]= new Usuario_Chat($socket);
    }
    
    public function findWithSocket($socket)
    {
        foreach ($this->usuarios as $key ) {
           if($key->socket==$socket){
            return $key;
           }
        }
        return false;
    }
    
    public function findWithToken($token)
    {
        foreach ($this->usuarios as $key ) {
            if($key->token==$token){
             return $key;
            }
        }
         return false;
     
    }
    public function findWithId($token)
    {
        foreach ($this->usuarios as $key ) {
            if($key->id==$token){
             return $key;
            }
        }
         return false;
     
    }

    public function getUsuarios()
    {
        return $this->usuarios;
    }

    public function updateUserWithSocket($socket,$u)
    {
        $usuario=$this->findWithSocket($socket);
        $usuario->setUsuario($u);
        return $usuario;
    }
    
}