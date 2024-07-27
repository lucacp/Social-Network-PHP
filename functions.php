<?php
session_start();

require 'connect.php';
$connection = getPDOConnection($config,$dbType);
$sql 		= new Sql();
function runthis($query,$param)
{
	global $connection;
	//$paramCount = count($param);
	try{
		$stmt = $connection->prepare($query);
		$result = $stmt->execute($param);
	} catch(\PDOException $e){ 
		die($e->getMessage().'<br />');
	}
	return ['result'=>$result,'fetch_array'=>$stmt,'num_rows'=>$stmt->rowCount()];
	
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
class Sql 
{
	function LoginMember(){
		return 'SELECT user,pass FROM members WHERE user=:user AND pass=:pass';
	}
	function SignUpMember(){
		return 'INSERT INTO members VALUES(:user, :pass)';	
	}
	function SignUpMemberExist(){
		return 'SELECT * FROM members WHERE user=:user';
	}
	function ViewPostsIdDesc(){
		return 'SELECT * FROM posts ORDER BY ID DESC';
	}
	function ViewFollowers(){
		return "SELECT * FROM follower WHERE user1=:currentuser AND user2=:user";
	}
	function ViewPhotosFromUser(){
		return "SELECT * FROM photos WHERE user=:user";
	}
	function UpdatePhotosCountUser(){
		return "UPDATE photos SET count=:count WHERE user=:user";
	}
	function InsertPost(){
		return "INSERT INTO posts (author,content,upvotes,id,photo)VALUES(:user, :content, 0, 0,:saveto)";
	}
	function CreatePhotosCountUser(){
		return "INSERT INTO photos VALUES (count=:count, user=:user)";
	}
}
