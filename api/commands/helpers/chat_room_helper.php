<?php
namespace app\commands\helpers;
class ChatRoomHelper{
    public static function FindWithChatRoomId( $chat_rooms,$chat_room_id)
    {
        foreach ($chat_rooms as $key ) {
           if($key->get_chat_room_id()==$chat_room_id){
                return $key;
           }
          
        }
        return false;
    }
    //El siguiente metodo sirve  para encontra los chat room  de  2 usuarios pertenecientes al mismo match
    public static function FindWithMatchId( $chat_rooms,$match_id)
    { $return=[];
        foreach ($chat_rooms as $key ) {
            if($key->get_match_id()==$match_id){
                 $return[]=$key;
            }
           
         }
         return $return;
    }

    //Este metodo sirve para encontrar el chat room que se le esta mostrando al SEGUNDO usuario o usuario2
    //En un futuro se puede usar para cambiar el estado del usuario de forma dinamica e indicarle al primer usuario si esta escriviendo, mandando audio, desconectado
    public static function FindWithUsuarioId2( $chat_rooms,$u2)
    { $return=false;
        foreach ($chat_rooms as $key ) {
            if($key->get_usuario2()["id"]==$u2){
                 $return=$key;
            }
           
         }
         return $return;
    }
    
    public static function FindWithUsuari1id( $chat_rooms,$u1)
    {
        $return=false;
        foreach ($chat_rooms as $key ) {
            if($key->get_usuario1()["id"]==$u1){
                 $return=$key;
            }
           
         }
         return $return;
    }
}