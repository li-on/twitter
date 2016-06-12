<?php
/**
 *	Kod wspólny dla aplikacji
 *
 */

require_once(__DIR__.'/config.php');

//autoładowanie klas z katalogu lib
spl_autoload_register(function ($n) {
    if(file_exists(__DIR__.'/lib/'.$n.'.php')) {
        require_once __DIR__.'/lib/'.$n.'.php';
        return true;
    } 
});


//biblioteka ADODB
require_once(__DIR__.'/../vendor/adodb/adodb-php/adodb.inc.php');
require_once(__DIR__.'/../vendor/adodb/adodb-php/adodb-errorhandler.inc.php');

if(!defined('ADODB_ERROR_LOG_TYPE')) define('ADODB_ERROR_LOG_TYPE', 3);
if(!defined('ADODB_ERROR_LOG_DEST')) define('ADODB_ERROR_LOG_DEST', __DIR__.'/log/db_'.date('Y-m-d').'.log');


$ADODB_CACHE_DIR = __DIR__.'/adodb_cache';
	
$db = ADONewConnection('mysqli');

//$db->debug=true;

$db->SetFetchMode(ADODB_FETCH_ASSOC);
$db->charSet = 'UTF8';
$db->PConnect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

//opcjonalnie memcached
/*
$db->memCache = true;
$db->memCacheHost = array('127.0.0.1'); 
$db->memCachePort = 11211;
$db->memCacheCompress = false;
*/

Rejestr::set('db',$db);
