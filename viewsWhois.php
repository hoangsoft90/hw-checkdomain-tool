<?php
session_start();	//session start
include('functions.php');

if(isset($_SERVER['HTTP_REFERER']) ){
	$parse = parse_url($_SERVER['HTTP_REFERER']);
	if($parse['host'] == $_SERVER['SERVER_NAME']){	//sure come from same domain?
		$domain = $_GET['domain'];
		echo cacheWhoisDomain($domain);
	}
}
?>