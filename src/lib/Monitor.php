<?php
/**
 *	Klasa monitorująca usługę
 *
 *	Sprawdza czy jest połączenie do bazy i jaki był ostatni zapis statusu
 *
 *
 */
class Monitor{

	/**
	 * Funkcja zwracająca tablicę ze statusem
	 * 
	 * 
	 * @return array wynik
	 */
	function status(){
		//sprawdzanie czy proces zablokował PID
		$lock_file = fopen(__DIR__.'/../usluga.pid', 'c');
		$got_lock = flock($lock_file, LOCK_EX | LOCK_NB, $wouldblock);
		if($lock_file === false || (!$got_lock && !$wouldblock)) {
			$wynik=array('status'=>'ER','komunikat'=>'Brak dostępu do pliku usluga.pid');
			return $wynik;
		}else if($got_lock){
			$wynik=array('status'=>'ER','komunikat'=>'Usługa nie jest uruchomiona');
			flock($lock_file, LOCK_UN);
			return $wynik;
		}
		
		// i czy jest baza danych
		$db=Rejestr::get('db');
		if(empty($db) || !$db->IsConnected()){
			$wynik=array('status'=>'ER','komunikat'=>'Brak bazy danych');
		}else{
			//status usługi z bazy
			$wynik=$db->GetRow('SELECT * FROM `twitter_status` ORDER BY id DESC LIMIT 1');
		}
		return $wynik;	
	}

}