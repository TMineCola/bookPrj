<?php
    //啟動session功能
    session_start();
    //導入model.php及loginModel.php(如果要使用model.php及loginModel.php裡面的功能就要導入)
    require("model.php");
    require_once('loginModel.php');

    //檢查是否有登入(cookie存在uID), 如果沒有登入就導至loginForm.php
    if(!isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
        header("Location: loginForm.php");
        exit(0);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>推薦書單系統</title>
    </head>
    <body>
        <p>我的個人推薦書單&nbsp;&nbsp;[<a href='loginForm.php'>點擊登出</a>]&nbsp;&nbsp;[<a href='view.php'>回到所有推薦書單瀏覽</a>]</p>
        <hr />
        <table width="800" border="1">
        <tr>
            <td>編號</td>
            <td>書名</td>
            <td>推薦訊息</td>
            <td>作者</td>
            <td>推薦者</td>
            <td>按讚數</td>
        </tr>
        <?php
            //呼叫model.php裡面的getBookList函式, 並將回傳的結果存到results
            //回傳內容為：目前登入使用者所建立的書單
            $results = getSelfBookList($_SESSION['uID']);

            //將回傳內容逐列顯示, Usage: $rs['欄位名稱']
            //請記得使用 "," 將字串及變數分開
            while ($rs = mysqli_fetch_array($results)) {
                echo "<tr><td>" , $rs['id'] ,"<br />",
                "<a href='control.php?act=delete&id=",$rs['id'] ,"'>砍</a> | ",
                "<a href='editMessageForm.php?id=",$rs['id'] ,"'>改</a> | ",
                "<a href='control.php?act=like&id=",$rs['id'] ,"'>推</a> | ",
                "<a href='control.php?act=unlike&id=",$rs['id'] ,"'>噓</a> | ",
                "<a href='viewDetail.php?id=",$rs['id'] ,"'>View Detail</a>",
                "</td><td>" , $rs['title'],
                "</td><td>" , $rs['msg'],
                "</td><td>", $rs['author'],
                "</td><td>", $rs['name'],
                "</td><td>(", $rs['push'], ")</td></td></tr>";
            }
        ?>
        </table>
    </body>
</html>
