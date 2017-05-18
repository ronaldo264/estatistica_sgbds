<?php
    $hostname_config = "localhost";
    $database_config = "testeestatistica";
    $username_config = "root";
    $password_config = "";
    $config = mysqli_connect($hostname_config, $username_config, $password_config,$database_config) or trigger_error(mysql_error(),E_USER_ERROR); 
