<?php
namespace tests\unit\models;

use app\models\Mach;

class MatchTest extends \Codeception\Test\Unit{
    //Obtener Lista usuario cuando no se han dado like

    public function testGetUsersNoMostradosCon0UsuariosEncontrados(){
        $this->assertSame(0,count(Mach::getUsersNoMostrados("test",0)));
    }

    public function testGetUsersNoMostradosCon1UsuariosEncontrados(){
        $this->assertEquals(1,count(Mach::getUsersNoMostrados("test",1)));
    }

    public function testGetUsersNoMostradosCon3UsuariosEncontrados(){
        $this->assertEquals(3,count(Mach::getUsersNoMostrados("test",3)));
    }
    
    //verificamos que el numero de parametros en la respuesta 
    public function testGetUsersNoMostradosCount(){
        $this->assertEquals(5,count(Mach::getUsersNoMostrados("test",1)[0]));
    }
    public function testGetUserMatches(){
        
    }
   
}