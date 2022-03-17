<?php
public function imlementarAutenticacion(Type $var = null)
{
    if ($this->request->isPost) {
        $u=self::getUserWhithAuthToken();
        if(isset($u['error'])){
            return $u['error'];
        }
        # code ...
    }
    return ["error"=>"Algo ha salido mal"];
}