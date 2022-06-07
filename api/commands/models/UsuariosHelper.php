<?php
namespace app\commands\models;
require_once("usuario_chat.php");
use app\commands\models\Usuario_Chat;

class UsuarioHelper{
    private $usuarios;
    
    public function __construct() {
       $this->usuarios=[];

    }

    public function addUsuario($socket)
    {
        $usuario= new Usuario_Chat($socket);
        
        $this->usuarios[]=$usuario;
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
            if($key->getToken()==$token){
             return $key;
            }
        }
         return false;
     
    }
    public function findWithId($id)
    {  
        foreach ($this->usuarios as $key ) {
            echo"Imprimiendo key";
            var_dump($key->getId());
            echo"Imprimiendo id";
            var_dump($id);
            if($key->getId()===$id){
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
        echo "Update";
        $usuario=$this->findWithSocket($socket);
        $usuario->setUsuario($u);
        return $usuario;
    }
    
}