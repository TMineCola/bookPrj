<?php
    require("dbconnect.php");

    function getBookList() {
        global $conn;
        //$sql = "select * from guestbook;";
        $sql = "SELECT book.*, user.name FROM book, user WHERE book.uID=user.id";

        return mysqli_query($conn, $sql);
    }

    function deleteBook($id) {
        global $conn;

        //對$id 做基本檢誤
        $id = (int) $id;

        //產生SQL
        $sql = "DELETE FROM book WHERE id = $id;";
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
            $sql = "INSERT INTO book (title, msg, author, uID) VALUES ('$title', '$msg','$author', $uID);";
            return mysqli_query($conn, $sql); //執行SQL
        } else return false;
    }

    function getBookDetail($id) {
        global $conn;
        if($id >0 ) {
            $sql = "SELECT book.*, user.name FROM book, user WHERE book.uID=user.id AND book.id=$id;";
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
            $sql = "UPDATE book SET title='$title', msg='$msg', author='$author' WHERE id=$id;";
            mysqli_query($conn, $sql) or die("Insert failed, SQL query error"); //執行SQL
        }
    }

    function likeBook($id) {
        global $conn;

        //對$id 做基本檢誤
        $id = (int) $id;

        //產生SQL
        $sql = "UPDATE book SET push = push + 1 WHERE id=$id;";
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
            $sql = "INSERT INTO comment (bkID, msg, uID) VALUES ($bkID, '$msg',$uID);";
            return mysqli_query($conn, $sql); //執行SQL
        } else return false;
    }

    function getComment($bkID) {
        global $conn;
        $sql = "SELECT comment.*, user.name AS userName FROM comment, user WHERE comment.uID = user.id AND comment.bkID = $bkID";

        return mysqli_query($conn, $sql);
    }

    function deleteComment($id) {
        global $conn;

        //對$id 做基本檢誤
        $id = (int) $id;

        //產生SQL
        $sql = "DELETE FROM comment WHERE id=$id;";
        return mysqli_query($conn, $sql); //執行SQL
    }
?>