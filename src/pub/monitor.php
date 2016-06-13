<?php
/**
 *	Us³uga monitoruj¹ca stan
 *	{
 *		"status":"OK",				//status us³ugi OK/ER
 *		"komunikat":"Test",			//komunikat b³êdu
 *		"czas":2016-01-01 23:59:59"	//opcjonalnie - czas ostatniej zmiany statusu
 *	}
 */

require_once(__DIR__.'/../wspolne.php');

//TODO: powinien byæ jakiœ mechanizm autoryzacji

$m=new Monitor();
$wynik=$m->status();
header('Content-Type: application/json');
echo json_encode($wynik);