<?php
    //啟動session功能
    session_start();
    //導入model.php (如果要使用model.php裡面的功能就要導入)
    require("model.php");
    //導入loginModel.php, 為了使用getUserName來得到使用者名稱
    require("loginModel.php");
    //檢查是否有登入(cookie存在uID), 如果沒有登入就導至loginForm.php
    if (!isset($_SESSION['uID']) or $_SESSION['uID'] <= 0) {
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
        <p>所有推薦書單瀏覽&nbsp;&nbsp;[<a href='loginForm.php'>點擊登出</a>]&nbsp;&nbsp;[<a href='viewSelf.php?uID=<?php echo $_SESSION['uID']; ?>'>我的個人推薦書單</a>]</p>
        <hr />
        <table width="850" border="1">
        <tr>
            <td>編號</td>
            <td>書名</td>
            <td>作者</td>
            <td>按讚數</td>
            <td>推薦者</td>
            <td>語言</td>
            <td>操作</td>
        </tr>
        <?php
            //呼叫model.php裡面的getBookList函式, 並將回傳的結果存到results
            //回傳內容為：目前登入使用者所建立的書單
            $results = getBookList();

            //將回傳內容逐列顯示, Usage: $rs['欄位名稱']
            //請記得使用 "," 將字串及變數分開
            while ($rs = mysqli_fetch_array($results)) {
                echo "<tr><td>" , $rs['id'] ,"<br />",
                "</td><td>" , $rs['title'],
                "</td><td>", $rs['author'],
                "</td><td>(", $rs['push'], ")",
                "</td><td><a href='viewSelf.php?uID=", $rs['uID'], "'>",$rs['name'], "</a>",
                "</td><td>";
                switch($rs['language']) {
                    case 0:
                        echo "中";
                        break;
                    case 1:
                        echo "英";
                        break;
                    case 2:
                        echo "日";
                        break;
                    case 3:
                        echo "其他";
                        break;
                }
                echo "</td><td><a href='control.php?act=delete&id=",$rs['id'] ,"'>砍</a> | ",
                "<a href='editMessageForm.php?id=",$rs['id'] ,"'>改</a> | ",
                "<a href='control.php?act=like&id=",$rs['id'] ,"'>推</a> | ",
                "<a href='control.php?act=unlike&id=",$rs['id'] ,"'>噓</a> | ",
                "<a href='viewDetail.php?id=",$rs['id'] ,"'>View Detail</a></td></tr>";
            }
        ?>

        <tr>
            <!-- 表單以post的方式送至control.php -->
            <form method="post" action="control.php">
                <td>
                    <label>
                        <input type="submit" name="Submit" value="新增" />
                        <input name="act" type="hidden" value='insert' />
                    </label>
                </td>
                <td>
                    <label>
                        <input name="title" type="text" id="title" />
                    </label>
                </td>
                <td>
                    <label>
                        <input name="msg" type="text" id="msg" />
                    </label>
                </td>
                <td>
                    <label>
                        <input name="author" type="text"  />
                    </label>
                </td>
                <td>
                    語言
                    <select name="language">
                        <option value="0"> 中 </option>
                        <option value="1"> 英 </option>
                        <option value="2"> 日 </option>
                        <option value="3"> 其他 </option>
                    </select>
                </td>
                <td colspan="2">
                    <label>
                        <?php
                            echo "當前使用者: ", getUserName($_SESSION['uID']);
                        ?>
                        <!-- 將使用者的uID以隱藏的input元素藏在Form裡面送出 -->
                        <input name="myname" type="hidden" id="myname" value='<?php echo $_SESSION['uID']; ?>' />
                    </label>
                </td>
            </form>
        </tr>
        </table>
    </body>
</html>
