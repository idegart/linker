<?php

return [
    'connection' => defined('LINKER_CONNECTION') ? LINKER_CONNECTION : 'mysql:host=127.0.0.1',
    'name' => defined('LINKER_TABLE_NAME') ? LINKER_TABLE_NAME : 'linker',
    'user' => defined('LINKER_TABLE_USER') ? LINKER_TABLE_USER : 'root',
    'password' => defined('LINKER_TABLE_PASSWORD') ? LINKER_TABLE_PASSWORD :'',
    'options' => defined('LINKER_TABLE_OPTIONS') ? LINKER_TABLE_OPTIONS :[
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
];
