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
        <p>推薦書單詳細內容&nbsp;&nbsp;[<a href='loginForm.php'>點擊登出</a>]&nbsp;&nbsp;[<a href='view.php'>回到所有推薦書單瀏覽</a>]</p>
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
            //將從網址"?id="中Get到的推薦書單編號存入bkID
            $bkID = (int)$_REQUEST['id'];
            //呼叫model.php裡面的getBookDetail函式, 並將回傳的結果存到results
            //回傳內容為：該編號的推薦書單內容
            $results = getBookDetail($bkID);

            //將回傳內容顯示, Usage: $rs['欄位名稱']
            //請記得使用 "," 將字串及變數分開
            //由於這邊只會有一筆資料, 只要確定有資料就可以直接顯示, 不需要用while跑
            if ($rs = mysqli_fetch_array($results)) {
                echo "<tr><td>" , $rs['id'] ,"<br />",
                "<a href='control.php?act=delete&id=",$rs['id'] ,"'>砍</a> | ",
                "<a href='editMessageForm.php?id=",$rs['id'] ,"'>改</a> | ",
                "<a href='control.php?act=like&id=",$rs['id'] ,"'>推</a>",
                "<a href='control.php?act=unlike&id=",$rs['id'] ,"'>噓</a> | ",
                "</td><td>" , $rs['title'],
                "</td><td>" , $rs['msg'],
                "<td>", $rs['author'],
                "<td>", $rs['name'],
                "<td>(", $rs['push'], ")</td></td></tr></table>";
            } else {
                echo "<h4>找不到該推薦書單</h4></table>";
            }

            //顯示分隔線並產生新的Table來顯示回應, 提醒：如果要再echo"";裡面加上含有雙引號的條件需要用\讓系統不會誤判
            echo "<hr><table width=\"800\" border=\"1\"><tr><td>回應</td><td>作者</td></tr>";

            //呼叫model.php裡面的getComment函式, 並將回傳的結果存到results
            //回傳內容為：該推薦書單的所有回應
            $results = getComment($bkID);

            while ($rs = mysqli_fetch_array($results)) {
                //顯示回應訊息及回應者
                echo "<tr><td>",$rs['msg'],"</td><td>",$rs['userName'];
                //呼叫model.php裡面的isAdmin函式, 檢查該登入帳號是否為管理員
                //如果是則顯示刪除回應的連結
                if (isAdmin($_SESSION['uID'])) {
                    echo "<a href ='control.php?act=deleteComment&id=",$rs['id'],"'>[刪除回應]</a></td></tr>";
                } else {
                    echo "</td></tr>";
                }
            }
            echo "</table>"
        ?>
        <hr>
        <!-- 將新增留言的資料以post的方式送至control.php -->
        <form method="post" action="control.php">
            <label>
                <!-- 將書本編號(bkID)及事件行為(act)以隱藏的input元素藏在Form裡面送出 -->
                <input name="bkID" type="hidden" value='<?php echo $bkID;?>' />
                <input name="act" type="hidden" value='insertComment' />
            </label>
            <label>
                <?php
                    echo "當前使用者: ", getUserName($_SESSION['uID']);
                ?>
                <br/>
                我要留言：
                <input name="msg" type="text" id="msg" />
                <input type="submit" name="Submit" value="新增" />
            </label>
        </form>
    </body>
</html>
