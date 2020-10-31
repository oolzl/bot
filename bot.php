<?php
ob_start();
$API_KEY = "1488858485:AAGunS_GKTMNOgYGL-mZAolHcLYl14cfzQk";
$admin = 1168667046;
define("API_KEY",$API_KEY);
function bot($method,$str=[]){
        $http_build_query = http_build_query($str);
        $api = "https://api.telegram.org/bot".API_KEY."/".$method."?$http_build_query";
        $http_build_query = file_get_contents($api);
        return json_decode($http_build_query);
}

$update = json_decode(file_get_contents("php://input"));
$message = $update->message;
$id = $message->from->id;
$chat_id = $message->chat->id;
$text = $message->text;
$message_id = $message->message_id;
$type = $message->chat->type;
$replyid = $message->reply_to_message->message_id;
$info = json_decode(file_get_contents('info.json'),true);
$infoget= json_decode(file_get_contents('info.json'));
$relpymessageid = $infoget->chat->$replyid;


if ($text == "/start") {
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"أهلا بك في بوت التواصل الجديد",
]);
}


if($type == 'private' && $id != $admin){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"وصلت الرسالة",
]);
$bot = bot('forwardMessage',[
'chat_id'=>$admin,
'from_chat_id'=>$chat_id,
'message_id'=>$message_id
]);
$getidmessage = $bot->result->message_id;
$info["chat"]["$getidmessage"] = "$chat_id";
file_put_contents('info.json', json_encode($info));
}

if ( $id == $admin ){
bot('sendMessage',[
'chat_id'=>$relpymessageid,
'text'=>$text,
]);
}