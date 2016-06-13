twitter

===============

Prosta aplikacja monitoruj�ca tweety z zadan� fraz�

Instalacja
------------

Pobieranie zale�no�ci
	
	php composer.phar install
	
Pobieranie zale�no�ci - bez deweloperskich, tylko do uruchomienia
	
	php composer.phar install --no-dev
	
Zapisz plik src/config-tpl.php jako src/config.php i uzupe�nij zmienne konfiguracyjne

Zainicjuj baz� danych skryptem sql/ddl.sql

Katalog src/pub zawiera us�ugi dost�pne publicznie, powinien zosta� udost�pniony na serwerze www

Dodaj uprawnienia do zapisu dla katalog�w src/log i src/adodb_cache

Uruchomienie
------------

Uruchomienie pobierania tweet�w
	
	php src/usluga.php
	
	
Uruchomienie pobierania tweet�w - uruchomienie w tle
	
	php src/usluga.php > usluga.log &
	
	
Us�ugi
------------

W katalogu src/pub znajduj� si� 2 us�ugi

index.php - wy�wietla statystyki tweet�w
monitor.php - sprawdza stan us�ugi

	

	
