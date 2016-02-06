<?php
session_start();
include('config.php');
include('functions.php');
//get task
$task = $_GET['do'];
if($task == 'clear_history'){
	clearHistory();
}
?>