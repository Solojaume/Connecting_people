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

    public function disconectUsuarioBySocket($socket)
    {
        $u=$this->findWithSocket($socket);
        echo "\n Desconectar USUARIO";
        var_dump(array_search($u,$this->usuarios));
        $newUsuarioIndex = array_search($u,$this->usuarios);
        unset($this->usuarios[$newUsuarioIndex]);
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
        echo"\n Lista de usuarios\n";
        var_dump($this->usuarios);
        foreach ($this->usuarios as $key ) {
            echo"\nImprimiendo key";
            var_dump($key->getId());
            echo"\nImprimiendo id";
            var_dump($id);
            var_dump($key->getId().""==$id);
            if($key->getId().""===$id){
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