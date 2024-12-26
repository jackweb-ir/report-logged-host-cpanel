<?php

// set cron job 1 min

error_reporting(0);

define('TOKEN',''); // your bot token
define('ADMIN','-100111111'); // telegram channel id
$domain1 = "domain.com"; // your domain

function bot($method,$datas=[])
{

    $url = "https://api.telegram.org/bot".TOKEN."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);

    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        curl_close($ch);
        return json_decode($res);
    }

}

$lastip = @file_get_contents('./.lastip');

$newip = end(file(end(glob('/home/*/.lastlogin'))));

if(isset($lastip) and $lastip != $newip)
{

    file_put_contents('./.lastip',$newip);

    bot('sendMessage',[
        'chat_id'=>ADMIN,
        'text'=>"⚠️ Someone logged into your cPanel host with the following IP address !\nIP : <code>$newip</code>\nAddress Host : $domain1",
        'parse_mode'=>'HTML',
        'disable_web_page_preview'=>true,
    ]);

}


