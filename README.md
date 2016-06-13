twitter

===============

Prosta aplikacja monitoruj¹ca tweety z zadan¹ fraz¹

Instalacja
------------

Pobieranie zale¿noœci
	
	php composer.phar install
	
Pobieranie zale¿noœci - bez deweloperskich, tylko do uruchomienia
	
	php composer.phar install --no-dev
	
Zapisz plik src/config-tpl.php jako src/config.php i uzupe³nij zmienne konfiguracyjne

Zainicjuj bazê danych skryptem sql/ddl.sql

Katalog src/pub zawiera us³ugi dostêpne publicznie, powinien zostaæ udostêpniony na serwerze www

Dodaj uprawnienia do zapisu dla katalogów src/log i src/adodb_cache

Uruchomienie
------------

Uruchomienie pobierania tweetów
	
	php src/usluga.php
	
	
Uruchomienie pobierania tweetów - uruchomienie w tle
	
	php src/usluga.php > usluga.log &
	
	
Us³ugi
------------

W katalogu src/pub znajduj¹ siê 2 us³ugi

index.php - wyœwietla statystyki tweetów
monitor.php - sprawdza stan us³ugi

	

	
