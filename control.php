<?php
session_start();
require_once('model.php');
require_once('loginModel.php');
$action =$_REQUEST['act'];

switch ($action) {
case 'delete':
$id = (int) $_REQUEST['id'];
	if ($id > 0) {
		deleteBook($id);
	}
	break;
case 'insert':
	$title=$_REQUEST['title'];
	$msg=$_REQUEST['msg'];
	$name=$_REQUEST['myname'];
	insertBook($title, $msg, $name, $_SESSION['uID']);
	break;
case 'update':
	$id = (int) $_REQUEST['id'];
	$title=$_REQUEST['title'];
	$msg=$_REQUEST['msg'];
	$name=$_REQUEST['myname'];
	updateBook($id, $title, $msg, $name);
	break;
case 'like':
	$id = (int) $_REQUEST['id'];
	if ($id > 0) {
		likeBook($id);
	}
	break;
case 'insertComment':
	$bkID=(int)$_REQUEST['bkID'];
	$msg=$_REQUEST['msg'];
	insertComment($bkID, $msg, $_SESSION['uID']);
	break;
case 'deleteComment':
	$id = (int) $_REQUEST['id'];
	if ($id > 0 and isAdmin($_SESSION['uID'])) {
		deleteComment($id);
	}
	break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
</head>
<body>
<a href='view.php'>執行完成，回留言板</a>
</body>
</html>