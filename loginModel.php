<?php
    //導入dbconnect.php (如果要使用dbconnect.php裡面的內容就要導入)
    require("dbconnect.php");

    //檢查使用者帳號密碼
    function checkUP($userName,$passWord) {
        global $conn;
        //將特殊SQL字元編碼，以免被SQL Injection
        $userName = mysqli_real_escape_string($conn,$userName);
        //從user資料表中查出該ID的密碼
        $sql = "SELECT password, id FROM user WHERE loginID='$userName'";
        //執行SQL查詢
        if ($result = mysqli_query($conn,$sql)) {
            //取得第一筆資料
            if ($row = mysqli_fetch_assoc($result)) {
                //比對密碼
                if ($row['password'] == $passWord) {
                    //密碼相符就回傳使用者的id編號
                    return $row['id'];
                } else {
                    //否則可以印出錯誤訊息
                    return 0;
                }
            } else {
                //搜尋不到該使用者的情況
                return 0;
            }
        } else{
            //SQL指令執行失敗的情況
            return 0;
        }
    }

    //檢查該使用者id是否為管理員
    function isAdmin($uID){
        global $conn;
        $uid = (int)$uID;
        //從user資料表中查出該ID的管理員狀態
        $sql = "SELECT Admin FROM user WHERE id = $uID";
        //執行SQL查詢
        if ($result = mysqli_query($conn,$sql)) {
            //取得第一筆資料
            if ($row = mysqli_fetch_assoc($result)) {
                //如果Admin資料表為1則是管理員, 若為0則為一般使用者
                if ($row['Admin'] == 1) {
                    //是管理員就回傳true
                    return true;
                } else {
                    //不是管理員
                    return false;
                }
            } else {
                //查不到資料
                return false;
            }
        }
        return false;
    }

    //取得目前登入者的名稱
    function getUserName($id) {
        global $conn;
        $id = (int) $id;
        $sql = "SELECT name FROM user WHERE id = $id";
        //執行SQL查詢
        if ($result = mysqli_query($conn,$sql)) {
            //取得第一筆資料
            if ($row = mysqli_fetch_assoc($result)) {
                return $row['name'];
            } else {
                //查不到資料
                return false;
            }
        }
        //查詢失敗
        return false;
    }
?>
