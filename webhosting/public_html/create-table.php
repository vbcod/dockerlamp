<?php

//$bdHost = '172.22.0.4';
$bdHost = 'dockerlamp--mysql';
$bdName = 'dockerlamp';
$bdUser = 'root';
$bdPass = '12345678';
$table  = 'tbl_dockerlamp';

//var_dump(class_exists('PDO'));die();

$db = new PDO("mysql:host={$bdHost};dbname={$bdName}", $bdUser, $bdPass );
$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
$sql ="CREATE TABLE IF NOT EXISTS {$table} (
     id INT(11) AUTO_INCREMENT PRIMARY KEY,
     name varchar (32) NOT NULL DEFAULT ''
);
" ;
$db->exec($sql);
print("Created $table Table.\n");
