<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_reversi = "localhost";
$database_reversi = "reversi";
$username_reversi = "admin";
$password_reversi = "1234";
$reversi = mysql_pconnect($hostname_reversi, $username_reversi, $password_reversi) or trigger_error(mysql_error(),E_USER_ERROR); 
?>