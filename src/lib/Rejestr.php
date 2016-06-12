<?php
/**
 * Rejestr - singleton do przechowywania obiektów globalnych
 */
class Rejestr {

    /**
     * @var tablica ze zmiennymi
     */
    public static $ustaw;

    /**
     *
     */
    protected function __construct() {}

    /**
	 * Pobieranie zmiennej
     * @param $nazwa nazwa w rejestrze
     * @return mixed zmienna
     */
    public static function get($nazwa){
        if (!isset(Rejestr::$ustaw[$nazwa])) {
            return null;
        }
        return(Rejestr::$ustaw[$nazwa]);
    }
	
	/**
	 * Sprawdzenie czy zmienna istnieje
     * @param $nazwa nazwa w rejestrze
     * @return boolean
     */
    public static function exists($nazwa){
        if (isset(Rejestr::$ustaw[$nazwa])) {
            return true;
        }else{
			return false;
		}
    }

    /**
	 * Zapis zmiennej
     * @param $nazwa nazwa zmiennej
     * @param $wartosc wartość
     */
    public static function set($nazwa, $wartosc){
        Rejestr::$ustaw[$nazwa]=$wartosc;
    }
}
