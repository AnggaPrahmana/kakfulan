<?php
/*
copyright @ medantechno.com
Modified by Ilyasa
2017
*/
require_once('./line_class.php');

$channelAccessToken = 'v/r/vHHGEPTpv0UVSDpMgJqwOuYG+HLrA6lR2pEI2OTjqLFZTwm/rEyznI4N/Cec4VmmBfjm4E4o4gl7WTjEDISpPy2G7lleHT5yBBNu4GiEItCROCFepFv1WoBrm49/TIpz+mKFgzXwTL7HCcTg8wdB04t89/1O/w1cDnyilFU='; //Your Channel Access Token
$channelSecret = 'a00b136247e88bbc32f9bb2cb6ef370e';//Your Channel Secret

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$message 	= $client->parseEvents()[0]['message'];
$profil = $client->profil($userId);
$pesan_datang = $message['text'];

if($message['type']=='sticker')
{	
	$balas = array(
		'UserID' => $profil->userId,
									'replyToken' => $replyToken,														
		'messages' => array(
			array(
					'type' => 'text',					
					'text' => 'Oi '.$profil->displayName.' Belike sticker aku ni'
				)
		)
	);
						
}

else
$pesan=str_replace(" ", "%20", $pesan_datang);
$key = 'a306aa56-c732-48c2-b19e-adaf07d772ec'; //API SimSimi
$url = 'http://sandbox.api.simsimi.com/request.p?key='.$key.'&lc=id&ft=1.0&text='.$pesan;
$json_data = file_get_contents($url);
$url=json_decode($json_data,1);
$diterima = $url['response'];
if($message['type']=='text'){
	if($url['result'] == 404){
		$balas = array(
							'UserID' => $profil->userId,	
                            'replyToken' => $replyToken,													
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Lagi main tenis nih'
									)
							)
						);
	}
	else if($url['result'] != 100){
		$balas = array(
							'UserID' => $profil->userId,
                            'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										//'text' => 'Hallo '.$profil->displayName
									)
							)
						);
	}

	else{
		$balas = array(
							'UserID' => $profil->userId,
                            'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => ''.$diterima.''
									)
							)
						);
	}
}
 
$result =  json_encode($balas);

file_put_contents('./reply.json',$result);


$client->replyMessage($balas);
