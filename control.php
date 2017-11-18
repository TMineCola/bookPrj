<?php
    session_start();
    require_once('model.php');
    require_once('loginModel.php');
    //除了依據請求方式得到資料如 $_GET['名稱'] or $_POST['名稱'], 可以使用$_REQUEST['名稱']來獲得資料, 而且不用區分方法
    //將請求的行為存入action
    $action =$_REQUEST['act'];
    //判斷行為呼叫對應的功能
    switch ($action) {
        case 'delete':
            //從請求中讀取id ,對id做基本錯誤檢查(強制轉成數字)
            $id = (int) $_REQUEST['id'];
            //基本錯誤檢查, 正常id一定會 > 0
            if ($id > 0) {
                //刪除該編號(id)推薦書單
                deleteBook($id);
            }
            break;
        case 'insert':
            //從請求中讀取資料
            $title = $_REQUEST['title'];
            $msg = $_REQUEST['msg'];
            $name = $_REQUEST['myname'];
            //新增推薦書單
            insertBook($title, $msg, $name, $_SESSION['uID']);
            break;
        case 'update':
            //從請求中讀取id ,對id做基本錯誤檢查(強制轉成數字)
            $id = (int) $_REQUEST['id'];
            //從請求中讀取資料
            $title = $_REQUEST['title'];
            $msg = $_REQUEST['msg'];
            $author = $_REQUEST['author'];
            //修改推薦書單
            updateBook($id, $title, $msg, $author);
            break;
        case 'like':
            //從請求中讀取id ,對id做基本錯誤檢查(強制轉成數字)
            $id = (int) $_REQUEST['id'];
            //基本錯誤檢查, 正常id一定會 > 0
            if ($id > 0) {
                likeBook($id);
            }
            break;
        case 'unlike':
            //從請求中讀取id ,對id做基本錯誤檢查(強制轉成數字)
            $id = (int) $_REQUEST['id'];
            //基本錯誤檢查, 正常id一定會 > 0
            if ($id > 0) {
                unlikeBook($id);
            }
            break;
        case 'insertComment':
            //從請求中讀取bkID ,對bkID做基本錯誤檢查(強制轉成數字)
            $bkID = (int)$_REQUEST['bkID'];
            //從請求中讀取資料
            $msg = $_REQUEST['msg'];
            //新增回應
            insertComment($bkID, $msg, $_SESSION['uID']);
            break;
        case 'deleteComment':
            //從請求中讀取id ,對id做基本錯誤檢查(強制轉成數字)
            $id = (int) $_REQUEST['id'];
            //基本錯誤檢查, 正常id一定會 > 0 及 檢查該登入使用者是否為管理員
            if ($id > 0 and isAdmin($_SESSION['uID'])) {
                //檢查通過則刪除回應
                deleteComment($id);
            }
            break;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>推薦書單系統</title>
    </head>
    <body>
        <!-- 請求執行完畢後顯示回主畫面的連結 -->
        <a href='view.php'>執行完成，回所有推薦書單瀏覽</a>
    </body>
</html>