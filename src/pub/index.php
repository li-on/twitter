<?php
/**
 *  Publicznie dost�pne API do pobierania ilo�ci tweet�w u�ytkownik�w na zadany temat
 *	Dla zwi�kszenia wydajno�ci - bez pomocniczych klas
 *
 *	Przyk�adowy format odpowiedzi:
 *	[
 *		{
 *			"id":"123456",			//id u�ytkownika na twitterze
 *			"name":"XYZ",			//nazwa u�ytkownika na twitterze
 *			"screen_name":"ABC",	//nazwa wy�wietlana u�ytkownika na twitterze
 *			"ilosc":"12"			//ilo�� tweet�w z monitorowan� fraz�
 *		}
 *	]
 */
require_once(__DIR__.'/../wspolne.php');

if(empty($db) || !$db->IsConnected()){
	header("HTTP/1.1 503 Service Unavailable");
	echo "B��d us�ugi";
	die();
}

$wynik=$db->CacheGetAll(7,'SELECT u.id, u.name, u.screen_name, c.ilosc FROM twitter_user u LEFT JOIN twitter_tweet_c_v c ON u.id=c.user_id');
if(!empty($wynik)){
	header('Content-Type: application/json');
	echo json_encode($wynik);
}else{
	header("HTTP/1.1 404 Not Found");
	echo "Brak wynik�w wyszukiwania";
}