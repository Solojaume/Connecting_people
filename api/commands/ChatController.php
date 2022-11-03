<?php

namespace app\commands;

use app\commands\models\ChatHandler;
use app\models\Mensajes;
use stdClass;
use yii\console\Controller;
use Workerman\Worker;
//require '../vendor/autoload.php';
//require_once 'C:\xampp\htdocs\connectingpeople\api\vendor\autoload.php';


class ChatController extends WebsocketController
{
    public function actionStart()
    { 
        $port = $GLOBALS["base_socket_io_port"];
        echo "port";
        var_dump($port);
        $host = $GLOBALS["base_socket_io_host"];
        echo "host";
        var_dump($host);
        $io = new SocketIOSustituto(
            $port,
            [
                "host" => $host
            ]
        );
        $GLOBALS["chathandler"] = new ChatHandler();
        $GLOBALS["usocket_by_id"] = [];
        $GLOBALS["usocket_by_token"] = [];
        $GLOBALS["users"] = [];
        $io->on('connection', function ($socket) {
            $socket->addedUser = false;


            // When the client emits 'add user', this listens and executes
            $socket->on('new user', function ($token) use ($socket) {
                echo "\n\n\n\n\n\n\nNuevo usuario";
                var_dump(date("H:i:s", time()));
                //global $usocket,$user ;
                $usocket_by_id = &$GLOBALS["usocket_by_id"];
                $usocket_by_token = &$GLOBALS["usocket_by_token"];
                $users = &$GLOBALS["users"];
                $chat_h = $GLOBALS["chathandler"];

                $men = $chat_h->auth($token);
                $u = $men["autenticacion"];

                if ($men["autenticacion"] == true) {
                    /*
                    echo "\n !in_array(token,usocket_by_token):";
                    var_dump(!self::in_array($token, $usocket_by_token));
                    echo "\nid:" . $u['id'];
                    echo "\n !in_array(id,usocket_by_id):";
                    var_dump(!in_array("id_" . $u["id"], $usocket_by_id));

                    echo "Autenticacion:";
                    var_dump($u);
                    */

                    if (!in_array($token, $usocket_by_token) && !in_array("id_" . $u["id"], $usocket_by_id)) {
                        echo "primer if";
                        // We store the username in the socket session for this client
                        $socket->usuario = $u;
                        unset($u["token"]);
                        unset($u["rol"]);

                        // Add the client's socket to the usocket by token list
                        $usocket_by_token[$token] = $socket;
                        // Add the client's socket to the usocket by id list
                        $usocket_by_id["id_" . $u["id"]] = $socket;
                        //Add user list
                        echo "\n in_array(u,users):";
                        var_dump(in_array($u, $users));

                        if (!in_array($u, $users)) {
                            $users[] = $u;
                        }

                        $devolver = CommandsMatchController::getChatsYMatches($token);
                        $devolver["usuarios"] = $users;
                        $devolver["mensajes_count"] = 0;
                        echo "\n usuarios añadido a devolver ";
                        $socket->emit('login', $devolver);
                        $socket->addedUser = true;
                        echo "\n Emited login";
                        // echo globally (all clients) that a person has connected
                        //$socket->broadcast->emit('user joined',["usuario"=>$u,"count"=>(count($users)-1)]);
                        //Este cambio se hace porque a un PUTO GENIO SE le ha ocurrido poner de parametro del push un never en vez de un jodido any
                        $socket->broadcast->emit('user joined', ["usuarios" => $users, "count" => (count($users) - 1)]);
                        echo "\n Emited broadcasting";

                        echo "\n Users:";
                        var_dump($users);
                        echo "\n Usocket:";
                        //var_dump($usocket);
                    }
                }
            });
            //Sirve paRA encontrar nuevos matches o chats
            $socket->on("update lista match", function ($object) use ($socket) {
                $usocket_by_id = &$GLOBALS["usocket_by_id"];
                $usocket_by_token = &$GLOBALS["usocket_by_token"];
                /*echo("\n\n Bienvenido");
                echo("\n PRE OBJECT");
                var_dump($object);
               // echo("\n Token".$object["token_usu"]);
                echo("\n PRE auth");*/
               
                if (!isset($usocket_by_token[$object["token"]])) {
                    //echo("\n Usuario no encontrado");
                    $socket->disconnect();
                }
                //echo("\n PrE Obtenido matches");
                $devolver = CommandsMatchController::getChatsYMatches($object["token"]);
                //echo("\n Obtenido matches");
                unset($object["token_usu"]);
                
                $devolver["mensajes_count"] = 0;
                //echo "\n  devolver  en actualizar match:";
                //var_dump($devolver);
                $socket->emit('update chats', $devolver);
                
            });

            // When the client emits 'typing', we broadcast it to others
            $socket->on('typing', function ($object) use ($socket) {
                $usocket_by_id = &$GLOBALS["usocket_by_id"];
                $usocket_by_token = &$GLOBALS["usocket_by_token"];
                //echo "\n\n\n\nTyping";

                if (!isset($usocket_by_token[$object["token_usu"]])) {
                    $socket->disconnect();
                }
                unset($object["token_usu"]);
                /* 
                // ----- Debug -----
                unset($object["token_usu"]);
                echo"\nUnset y Var_dump:";
                var_dump($object);
                echo"\n isset(usocket_by_id['id_'.object[id_usu2]]):";
                var_dump(isset($usocket_by_id["id_".$object["id_usu2"]]));
                echo"\nPots var dump";
                */
                //Reviso que el token este en el array usocket by token de esta manera autentifico antes de hacer nada
                if (isset($usocket_by_id["id_" . $object["id_usu2"]])) {
                    $socket2 = $usocket_by_id["id_" . $object["id_usu2"]];
                    //echo"\n socket2";
                    $socket2->emit('typing', $object);
                    //echo "\nEnviao";
                }
            });

            // When the client emits 'stop typing', we broadcast it to others
            $socket->on('stop typing', function ($object) use ($socket) {
                $usocket_by_id = &$GLOBALS["usocket_by_id"];
                $usocket_by_token = &$GLOBALS["usocket_by_token"];
                echo "\n\n\n\nStop Typing";

                if (!isset($usocket_by_token[$object["token_usu"]])) {
                    $socket->disconnect();
                }
                unset($object["token_usu"]);
                /* 
                // ----- Debug -----
                unset($object["token_usu"]);
                echo"\nUnset y Var_dump:";
                var_dump($object);
                echo"\n isset(usocket_by_id['id_'.object[id_usu2]]):";
                var_dump(isset($usocket_by_id["id_".$object["id_usu2"]]));
                echo"\nPots var dump";
                */
                //Reviso que el token este en el array usocket by token de esta manera autentifico antes de hacer nada
                if (isset($usocket_by_id["id_" . $object["id_usu2"]])) {
                    $socket2 = $usocket_by_id["id_" . $object["id_usu2"]];
                    //echo"\n socket2";
                    $socket2->emit('stop typing', $object);
                    //echo "\nEnviao";
                }
            });

            // When the client emits 'new message', this listens and executes
            $socket->on('send private message', function ($res) use ($socket) {
                //echo "\n\n\n ENTRA EN SEND";
                $usocket_by_token = $GLOBALS["usocket_by_token"];
                $usocket_by_id = $GLOBALS["usocket_by_id"];
                $users = &$GLOBALS["users"];
                /*echo "\n Mensajes:";
                var_dump($res);
                echo "Users en 'Send private message':";
                var_dump($users);
                */
                $token = &$res["token"];
                //echo "\n isset(usocket_by_token[token]):";
                //var_dump(isset($usocket_by_token[$token]));


                $mensaje = $res["mensage"];
                if (isset($usocket_by_token[$token])) {
                    unset($token);
                    //echo "\nDentro del if de send";

                    $mensajeBd = new Mensajes();
                    //echo "\n Post MensajeBd";
                    $mensajeBd->mensaje_contenido = $mensaje["chat_message"];
                    //echo "\nPost MensajeBd->mensaje_contenido";
                    $mensajeBd->entregado = 0;
                    //echo "\nPost MensajeBd->estado";
                    $mensajeBd->mensajes_usuario_id = $mensaje["chat_user"];
                    //echo "\nPost MensajeBd->mensajes_usuario_id";
                    $mensajeBd->mensajes_match_id = $mensaje["match_id"];
                    //echo "\nPost MensajeBd->mensajes_match_id";
                    if (isset($usocket_by_id["id_" . $res["usu_2"]])) {
                        $socket2 = $usocket_by_id["id_" . $res["usu_2"]];
                        $socket2->emit("receive private message", $mensaje);
                        //echo "\nRecived";
                        $mensajeBd->entregado = 1;
                    }
                    /*
                    echo "\nMensajeBd";
                    var_dump($mensajeBd);
                    echo "\nModel->save:";
                    */
                    if ($mensajeBd->save()) {
                        //echo "\nGUARDADOOO WIIIIIIIIIIIIIIIIIIIIIIII";
                    }
                    //var_dump($mensajeBd->save());
                }
                //echo "\n¡¡¡SALE DE SEND!!!\n\n\n";
            });

            $socket->on("update message", function ($data = null) use ($socket) {
                $usocket_by_id = &$GLOBALS["usocket_by_id"];
                $usocket_by_token = &$GLOBALS["usocket_by_token"];
                $users = &$GLOBALS["users"];
                $token = $data["token"];
                $mensaje = $data["message"];
                if (isset($usocket_by_token[$token])) {
                    $mns = Mensajes::findOne("mensajes_id=:e", [":e" => $mensaje["id"]]);
                    $mns->entregado = 2;
                    $mns->save();
                }
            });
            // When the user disconnects, perform this
            $socket->on('disconnect', function ($data) use ($socket) {
                //Desconectar usuario
                $usocket_by_id = &$GLOBALS["usocket_by_id"];
                $usocket_by_token = &$GLOBALS["usocket_by_token"];
                $users = &$GLOBALS["users"];
                echo "\nDesconectar Usuario:";
                //var_dump($socket);
                echo "\n SOCKET->usuario:";
                var_dump($socket->usuario);

                if (isset($socket->usuario)) {
                    $usuario_borrado = $socket->usuario;
                    unset($usuario_borrado["token"]);
                    unset($usuario_borrado["rol"]);
                    echo "\nIn array by token:";
                    var_dump(self::in_array($usocket_by_token, "token"));
                    if (self::in_array($usocket_by_token, $socket->usuario["token"])) {
                        echo "\n Entra en el if";
                        unset($usocket_by_token[$socket->usuario["token"]]);
                        $search = array_search($usuario_borrado, $users);
                        self::array_splice_remplazo($users, $search);
                        //unset($users[strrpos($users,$socket->username)]);

                    }
                    if (self::in_array($usocket_by_id, $socket->usuario["id"])) {
                        echo "\n Entra en el if";
                        unset($usocket_by_id[$socket->usuario["id"]]);
                        //array_splice($users,array_search($socket->usuario,$users),count($users)-1);
                        self::array_splice_remplazo($users, array_search($usuario_borrado, $users));
                    }
                } else {
                    echo "\n Entra en el else";
                    unset($usocket_by_id[NULL]);
                    self::array_splice_remplazo($users, array_search(NULL, $users));
                }
                echo "\n ARRay Users tras borrar usuario:";
                var_dump($users);
                $socket->broadcast->emit('user left', $users);
            });

            $socket->on('disconnect-by-token', function ($token) use ($socket) {
                $chat_h = $GLOBALS["chathandler"];
                if ($chat_h->auth($token)["autenticacion"] == true) {
                    $socket->disconnect();
                }
            });
        });

        Worker::runAll();
    }

    private static function array_search($nedle, $array, $campo = "id")
    {
        $devolver = [];
        for ($i = 0; $i < count($array); $i++) {
            if ($nedle[$campo] == $array[$i][$campo]) {
                return  $i;
                $devolver = $i;
            }
        }
        return $devolver;
    }

    public static function in_array($array, $object)
    {
        try {
            foreach ($array as $key => $value) {
                if ($key == $object) {
                    return true;
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }

        return false;
    }

    /*
    *Este metodo sirve para copiar ordenadamente el array a excepcion de la posicion pasada
    */
    public static function array_splice_remplazo(&$array, $position)
    {
        $ret = [];
        for ($i = 0; $i < count($array); $i++) {
            if ($position != $i) {
                $ret[] = $array[$i];
            }
        }
        $array = $ret;
    }
}
