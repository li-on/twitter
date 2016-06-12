<?php
/**
 *	Usługa działająca w tle - pobieranie danych
 *
 *	Uruchomienie: php usluga.php
 *
 */


//zapis PID procesu do pliku 
echo "Zapis PID do pliku\n";
$lock_file = fopen(__DIR__.'/usluga.pid', 'c');
$got_lock = flock($lock_file, LOCK_EX | LOCK_NB, $wouldblock);
if ($lock_file === false || (!$got_lock && !$wouldblock)) {
	die("Brak dostępu do pliku usluga.pid\n");
}
else if (!$got_lock && $wouldblock) {
	die("Instancja uruchomiona\n");
}
ftruncate($lock_file, 0);
fwrite($lock_file, getmypid() . "\n");

 
require_once(__DIR__.'/wspolne.php');
//API do Twittera
require_once(__DIR__.'/../vendor/j7mbo/twitter-api-php/TwitterAPIExchange.php');

//uruchomienie procesu pobierającego
echo "Start usługi\n";
$p=new Pobieracz();
$p->run();

ftruncate($lock_file, 0);
flock($lock_file, LOCK_UN);