<?php
/**
 *	Us�uga monitoruj�ca stan
 *	{
 *		"status":"OK",				//status us�ugi OK/ER
 *		"komunikat":"Test",			//komunikat b��du
 *		"czas":2016-01-01 23:59:59"	//opcjonalnie - czas ostatniej zmiany statusu
 *	}
 */

require_once(__DIR__.'/../wspolne.php');

//TODO: powinien by� jaki� mechanizm autoryzacji

$m=new Monitor();
$wynik=$m->status();
header('Content-Type: application/json');
echo json_encode($wynik);