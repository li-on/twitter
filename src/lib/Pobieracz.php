<?php

/**
 *	Klasa obsługująca pobieranie danych z twittera
 *	
 *
 *
 *
 */
class Pobieracz{
    /**
     * Obiekt API twittera
     */	
	protected $twitter;
	
	/**
     * Obiekt bazy danych z rejestru
     */	
	protected $db;
	
	/**
     * numer rekordu od którego rozpocząć kolejne pobieranie danych
     */	
	protected $since_id=0;
		
	/**
     * Status ostatniego żądania, każda zmiana statusu jest raportowana do bazy danych
     */	
	protected $ost_status='XX';

	
	function Pobieracz(){
		//inicjacja biblioteki do komunikacji z twitterem
		$settings = array(
			'oauth_access_token' => TWITTER_ACCESS_TOKEN,
			'oauth_access_token_secret' => TWITTER_ACCESS_TOKEN_SECRET,
			'consumer_key' => TWITTER_CONSUMER_KEY,
			'consumer_secret' => TWITTER_CONSUMER_SECRET
		);
		$this->twitter = new TwitterAPIExchange($settings);
		
		$this->db = Rejestr::get('db');
		
		$this->db->debug=true;
		
		//sprawdzenie czy w bazie są stare wpisy, aby ich na nowo nie pobierać
		$test=$this->db->GetOne('SELECT max(id) FROM twitter_tweet');
		if(!empty($test)){
			$this->since_id=$test;
			echo "Ostatnie ID: ".$test."\n";
		}
	}
	
    /**
     *	Główna metoda odpowiedzialan za działanie pobieracza 
     * 
     */
	function run(){	
		$url = 'https://api.twitter.com/1.1/search/tweets.json';
		$requestMethod = 'GET';
		while(1){
			$get = '?include_entities=0&count=100&q='.urlencode(TWITTER_SEARCH);
			$get .= '&since_id='.$this->since_id;

			try{
				echo "Pytam 1 strona\n";
				$odp = $this->twitter->setGetfield($get)->buildOauth($url, $requestMethod)->performRequest();
				$wynik=json_decode($odp,true);
				
				$this->zapisz($wynik);
				if(!empty($wynik['search_metadata']['max_id'])) $this->since_id=$wynik['search_metadata']['max_id'];
				while(!empty($wynik['search_metadata']['next_results'])){ //nastepne strony wyniku
					sleep(7);//limit 180 wywołań na 15 minut - max. 1 na 6 sekund.
					echo "Pytam kolejne strony\n";
					$odp = $this->twitter->setGetfield($wynik['search_metadata']['next_results'])->buildOauth($url, $requestMethod)->performRequest();
					$wynik=json_decode($odp,true);
					$this->zapisz($wynik);
				}
			}catch(Exception $e){
				$this->zapisz_blad("Błąd wywołania API twittera");
			}
			
			sleep(7);//limit 180 wywołań na 15 minut - max. 1 na 6 sekund.
		}
	}
	
    /**
     * Metoda pomocnicza do zapisu danych odebranych z serwisu do bazy danych
     * 
     * @param array $wynik Wynik otrzymany z serwisu twittera
     * 
     */
	protected function zapisz($wynik){
		if(!empty($wynik['statuses'])){
			if($this->ost_status != 'OK'){
				$this->ost_status = 'OK';
				$this->db->AutoExecute('twitter_status',array('status'=>'OK','czas'=>date('Y-m-d H:i:s')),'INSERT');
			}
			//zapis wyników do bazy
			foreach($wynik['statuses'] as $w){
				if(stripos($w['text'],TWITTER_SEARCH)!==FALSE){
					$this->db->Execute('INSERT IGNORE INTO twitter_user(id, name, screen_name) VALUES (?,?,?)',array($w['user']['id'],$w['user']['name'],$w['user']['screen_name']));
					$this->db->Execute('INSERT IGNORE INTO twitter_tweet(id, user_id, text, created_at) VALUES (?,?,?,?)',array($w['id'],$w['user']['id'],$w['text'],date('Y-m-d H:i:s',strtotime($w['created_at']))));
				}
			}
		}
		if(!empty($wynik['errors'])){
			//logowanie błędów
			$k=end($wynik['errors']);
			if($this->ost_status != 'ER'){
				$this->zapisz_blad($k['message']);
			}
		}
	}
	
	/**
     * Metoda pomocnicza do zapisu komunikatu błędu
     * 
     * @param string $komunikat Komunikat błędu
     * 
     */
	protected function zapisz_blad($komunikat){
		$this->ost_status = 'ER';
		$this->db->AutoExecute('twitter_status',array('status'=>'ER','komunikat'=>$komunikat,'czas'=>date('Y-m-d H:i:s')),'INSERT');
	}
	
}