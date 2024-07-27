<!DOCTYPE html>
<html>

<?php 

require_once 'functions.php';

$connection->query('CREATE TABLE IF NOT EXISTS members(user VARCHAR(16), pass VARCHAR(16))');
if($dbType=='mysql'){
	$connection->query('CREATE TABLE IF NOT EXISTS posts(author VARCHAR(16), content VARCHAR(256), upvotes INT, ID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(ID), photo VARCHAR(32))');
}elseif ($dbType=='sqlite') {
	$connection->query('CREATE TABLE IF NOT EXISTS posts(author VARCHAR(16), content VARCHAR(256), upvotes INT, ID INT NOT NULL PRIMARY KEY, photo VARCHAR(32))');
}
$connection->query('CREATE TABLE IF NOT EXISTS messages(sender VARCHAR(16), reciever VARCHAR(16), content VARCHAR(256), sendtime DATETIME)');

$connection->query("CREATE TABLE IF NOT EXISTS follower(user1 VARCHAR(16), user2 VARCHAR(16))");

$connection->query("CREATE TABLE IF NOT EXISTS photos (user VARCHAR(16), count INT)");

echo 'tables created';

?>