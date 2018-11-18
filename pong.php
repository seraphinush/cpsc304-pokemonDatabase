<?php
ini_set('session.save_path', getcwd() . "/../../public_html_sessions");
session_start();

echo $_SESSION['data'];
echo 'done';
?>
