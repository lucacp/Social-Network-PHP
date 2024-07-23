<?php
session_start();

$connection = require 'connect.php';

function runthis($query)
{
	global $connection;
	$result = $connection->query($query);
	if(!$result) die($connection->error);
	return $result;
}

function cleanup($var)
{
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);
	return escape_string($var);
}
function escape_string($param) {
    if(is_array($param))
        return array_map(__METHOD__, $param);

    if(!empty($param) && is_string($param)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $param);
    }

    return $param;
}

?>