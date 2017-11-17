<?php
    session_start();
    require("dbconnect.php");
    $id = (int)$_GET['id'];
    $id = (int)$_REQUEST['id'];
    $sql = "SELECT * FROM guestbook WHERE id=$id;";
    $result=mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message."); //執行SQL查詢
    if ($rs=mysqli_fetch_assoc($result)) {
        $title = $rs['title'];
        $msg=$rs['msg'];
        $name = $rs['name'];
    } else {
        echo "Your id is wrong!!";
        exit(0);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>無標題文件</title>
    </head>
    <body>
        <h1>edit Message: #<?php echo $id;?></h1>
        <form method="post" action="control.php?act=update">
            <input type="hidden" name='id' value="<?php echo $id;?>">
            Message Title: <input name="title" type="text" id="title" value="<?php echo $title;?>" /> <br>

            Message Body: <input name="msg" type="text" id="msg" value="<?php echo $msg;?>" /> <br>

            Author: <input name="myname" type="text" id="myname" value="<?php echo $name;?>" /> <br>

            <input type="submit" name="Submit" value="送出" />
            </form>
        </tr>
        </table>
    </body>
</html>
