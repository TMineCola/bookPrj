<?php
    require("dbconnect.php");
/*
    任何function裡面要取用與SQL連線的變數 $conn 一定要先以全域變數宣告 global $conn
    針對id類的安全檢查通常只要強制轉型為int即可 (int)id

    SQL的執行方式：
    先將sql指令以字串的方式存在變數中, 例如: $sql = "SELECT * from book";
    透過mysqli_query(連線物件, SQL指令)來執行, 例如: mysqli_query($conn, $sql);

    SQL指令過濾的方式：
    mysqli_real_escape_string(連線物件, 欲過濾的變數);
    例如: mysqli_real_escape_string($conn, $title);
*/
    //列出全部書單
    function getBookList() {
        global $conn;
        //選取所有推薦書單資訊 (由於書單資訊記載的推薦人是以編號(id), 所以還要額外從user資料表中搜尋user.id對應的暱稱)
        $sql = "SELECT book.*, user.name FROM book, user WHERE book.uID = user.id ORDER BY push DESC";
        //執行SQL指令並將結果回傳
        return mysqli_query($conn, $sql);
    }

    function getSelfBookList($uID) {
        global $conn;
        //選取目前登入使用者(uID)所有的推薦書單資訊 (由於書單資訊記載的推薦人是以編號(id), 所以還要額外從user資料表中搜尋user.id對應的暱稱)
        $sql = "SELECT book.*, user.name FROM book, user WHERE book.uID = user.id AND book.uID = $uID";
        //執行SQL指令並將結果回傳
        return mysqli_query($conn, $sql);
    }

    //刪除指定編號(id)的推薦書單
    function deleteBook($id) {
        global $conn;
        //對id做基本錯誤檢查(強制轉成數字)
        $id = (int) $id;
        //將該id的推薦書單從book資料表中刪除
        $sql = "DELETE FROM book WHERE id = $id;";
        //執行SQL指令並將結果回傳
        return mysqli_query($conn, $sql);
    }

    //新增一個推薦書單, (書名, 推薦訊息, 作者, 推薦人)
    function insertBook($title='', $msg='', $author='', $language='0',$uID) {
        global $conn;
        //檢查書名是否為空, 如果空則回傳false
        if ($title > ' ') {
            //基本安全處理(防SQL injection)
            $title = mysqli_real_escape_string($conn, $title);
            $msg = mysqli_real_escape_string($conn, $msg);
            $author = mysqli_real_escape_string($conn, $author);
            $language = mysqli_real_escape_string($conn, $language);
            $uID = (int)$uID;
            //新增一筆推薦書單進book資料表
            $sql = "INSERT INTO book (title, msg, author, language, uID) VALUES ('$title', '$msg','$author', '$language', $uID);";
            //執行SQL指令並將結果回傳
            return mysqli_query($conn, $sql);
        } else return false;
    }

    //獲得指定編號(id)的推薦書單
    function getBookDetail($id) {
        global $conn;
        //簡易的防錯誤(推薦書單編號一定大於0)
        if($id > 0) {
            //選取指定編號(id)推薦書單的全部內容
            $sql = "SELECT book.*, user.name FROM book, user WHERE book.uID=user.id AND book.id = $id";
            //將搜尋結果回傳
            $result = mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message."); //執行SQL查詢
        } else {
            //若錯誤則以false回傳
            $result = false;
        }
        return $result;
    }

    //修改指定編號(id)的推薦書單 (推薦書單編號, 書名, 推薦訊息, 作者)
    function updateBook($id, $title, $msg, $language, $author) {
        global $conn;
        //基本安全處理(防SQL injection)
        $title = mysqli_real_escape_string($conn,$title);
        $msg = mysqli_real_escape_string($conn,$msg);
        $author = mysqli_real_escape_string($conn,$author);
        $language = mysqli_real_escape_string($conn, $language);
        //對id做基本錯誤檢查(強制轉成數字)
        $id = (int)$id;

        //檢查title及id不為空
        if ($title and $id) {
            //將參數帶入SQL指令
            $sql = "UPDATE book SET title='$title', msg='$msg', author='$author', language='$language' WHERE id = $id";
            //執行SQL指令, 如果失敗則顯示修改失敗
            mysqli_query($conn, $sql) or die("Insert failed, SQL query error");
        }
    }

    //針對指定編號(id)的推薦書單按讚
    function likeBook($uID, $bkID) {
        global $conn;
        //對id做基本錯誤檢查(強制轉成數字)
        $bkID = (int) $bkID;
        $uID = (int) $uID;
        $logsql = "INSERT INTO push (uID,bkID) VALUES ('$uID', '$bkID')";
        mysqli_query($conn, $logsql);
        //將指定編號(id)原本的讚數 + 1
        $sql = "UPDATE book SET push = push + 1 WHERE id = $bkID;";
        //執行SQL指令
        return mysqli_query($conn, $sql);
    }

    //針對指定編號(id)的推薦書單按噓
    function unlikeBook($uID, $bkID) {
        global $conn;
        //對id做基本錯誤檢查(強制轉成數字)
        $bkID = (int) $bkID;
        $uID = (int) $uID;
        $logsql = "INSERT INTO unpush (uID,bkID) VALUES ('$uID', '$bkID')";
        mysqli_query($conn, $logsql);
        //將指定編號(id)原本的讚數 - 1
        $sql = "UPDATE book SET push = push - 1 WHERE id = $bkID;";
        //執行SQL指令
        return mysqli_query($conn, $sql);
    }

    function notPush($uID, $bkID) {
        global $conn;
        //對id做基本錯誤檢查(強制轉成數字)
        $bkID = (int) $bkID;
        $uID = (int) $uID;
        $sql = "SELECT number FROM push WHERE bkID = $bkID AND uID = $uID";
        $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            echo "你已經推過了！<br>";
            return false;
        } else {
            return true;
        }
    }

    function notunPush($uID, $bkID) {
        global $conn;
        //對id做基本錯誤檢查(強制轉成數字)
        $bkID = (int) $bkID;
        $uID = (int) $uID;
        $sql = "SELECT number FROM unpush WHERE bkID = $bkID AND uID = $uID";
        $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            echo "你已經噓過了！<br>";
            return false;
        } else {
            return true;
        }
    }

    function insertComment($bkID, $msg, $uID) {
        global $conn;

        if ($msg > ' ') {
            //對bkID做基本錯誤檢查(強制轉成數字)
            $bkID = (int) $bkID;
            //基本安全處理(防SQL injection)
            $msg = mysqli_real_escape_string($conn, $msg);
            //對uID做基本錯誤檢查(強制轉成數字)
            $uID = (int)$uID;
            //插入新的回應
            $sql = "INSERT INTO comment (bkID, msg, uID) VALUES ($bkID, '$msg',$uID);";
            //執行SQL指令
            return mysqli_query($conn, $sql);
        } else return false;
    }

    function getComment($bkID) {
        global $conn;
        //選取"對應推薦書單ID的回應", 將使用者名稱以 userName欄位顯示
        $sql = "SELECT comment.*, user.name AS userName FROM comment, user WHERE comment.uID = user.id AND comment.bkID = $bkID";
        return mysqli_query($conn, $sql);
    }

    function deleteComment($id) {
        global $conn;
        //對id做基本錯誤檢查(強制轉成數字)
        $id = (int) $id;
        //針對指定編號(id)的回應進行刪除
        $sql = "DELETE FROM comment WHERE id = $id";
        //執行SQL指令
        return mysqli_query($conn, $sql);
    }

    function addSeen($id) {
        global $conn;
        //對id做基本錯誤檢查(強制轉成數字)
        $id = (int) $id;
        //針對指定編號(id)的回應進行刪除
        $sql = "UPDATE book SET seen = seen + 1 WHERE id = $id";
        //執行SQL指令
        return mysqli_query($conn, $sql);
    }
?>