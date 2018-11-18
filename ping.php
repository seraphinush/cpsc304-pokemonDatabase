<?php 
ini_set('session.save_path', getcwd() . "/../../public_html_sessions");
session_start();

echo ini_get('session.save_path');
$_SESSION['data'] = 'ping';
echo 'done';
echo $_SESSION['data']
?>
