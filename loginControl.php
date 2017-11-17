<?php
    session_start();
    require_once('loginModel.php');
    $action =$_REQUEST['act'];

    switch ($action) {
        case 'login':
            //取得從loginForm.php傳來的POST帳號密碼參數
            $userName = $_POST['id'];
            $passWord = $_POST['pwd'];
            //比對密碼
            if ($id = checkUP($userName,$passWord)) {
                 //若正確則將userID存在session變數中，作為登入成功之記號
                $_SESSION['uID'] = $id;
                //導向書單瀏覽頁面
                header('Location: view.php');
            } else {
                //顯示錯誤訊息
                echo "無效的使用者帳號密碼, 請重試 <br />";
                echo "<a href=\"loginForm.php\">重新登入</a>";
            }
            break;
    }
?>