<?php
require("dbconnect.php");

function getBookList() {
	global $conn;
	//$sql = "select * from guestbook;";
	$sql = "select book.*, user.name from book, user where book.uID=user.id";

	return mysqli_query($conn, $sql);
}

function deleteBook($id) {
	global $conn;

	//對$id 做基本檢誤
	$id = (int) $id;
	
	//產生SQL
	$sql = "delete from book where id=$id;";
	return mysqli_query($conn, $sql); //執行SQL
}


function insertBook($title='', $msg='', $author='', $uID) {
	global $conn;

	if ($title > ' ') {
		//基本安全處理
		$title=mysqli_real_escape_string($conn, $title);
		$msg=mysqli_real_escape_string($conn, $msg);
		$author=mysqli_real_escape_string($conn, $author);
		$uID=(int)$uID;
		
		//Generate SQL
		$sql = "insert into book (title, msg, author, uID) values ('$title', '$msg','$author', $uID);";
		return mysqli_query($conn, $sql); //執行SQL
	} else return false;
}

function getBookDetail($id) {
	global $conn;
	if($id >0 ) {
		$sql = "select book.*, user.name from book, user where book.uID=user.id and book.id=$id;";
		$result=mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message."); //執行SQL查詢
	} else {
		$result = false;
	}
	return $result;
}

function updateMsg($id, $title, $msg, $author) {
	global $conn;
	$title=mysqli_real_escape_string($conn,$title);
	$msg=mysqli_real_escape_string($conn,$msg);
	$author=mysqli_real_escape_string($conn,$author);
	$id = (int)$id;

	if ($title and $id) { //if title is not empty
		$sql = "update book set title='$title', msg='$msg', author='$author' where id=$id;";
		mysqli_query($conn, $sql) or die("Insert failed, SQL query error"); //執行SQL
	}
}

function likeBook($id) {
	global $conn;

	//對$id 做基本檢誤
	$id = (int) $id;
	
	//產生SQL
	$sql = "update book set push = push+1 where id=$id;";
	return mysqli_query($conn, $sql); //執行SQL
}

function insertComment($bkID, $msg, $uID) {
	global $conn;

	if ($msg > ' ') {
		//基本安全處理
		$bkID=(int) $bkID;
		$msg=mysqli_real_escape_string($conn, $msg);
		$uID=(int)$uID;
		
		//Generate SQL
		$sql = "insert into comment (bkID, msg, uID) values ($bkID, '$msg',$uID);";
		return mysqli_query($conn, $sql); //執行SQL
	} else return false;
}

function getComment($bkID) {
	global $conn;
	//$sql = "select * from guestbook;";
	$sql = "select comment.*, user.name as userName from comment, user where comment.uID=user.id and comment.bkID=$bkID";

	return mysqli_query($conn, $sql);
}

function deleteComment($id) {
	global $conn;

	//對$id 做基本檢誤
	$id = (int) $id;
	
	//產生SQL
	$sql = "delete from comment where id=$id;";
	return mysqli_query($conn, $sql); //執行SQL
}
?>