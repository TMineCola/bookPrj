<?php
    session_start();
    require("dbconnect.php");
    //下方用法等同於 $id = (int)$_GET['id']; , _REQUEST的好處是不管是POST或GET的資料都會在這個變數陣列裡面
    //將GET請求中帶的推薦書單編號(id)存入變數，方便後面顯示取用
    $id = (int)$_REQUEST['id'];
    //選出該編號(id)的推薦書單資訊
    $sql = "SELECT * FROM book WHERE id = $id;";
    //執行SQL指令, 失敗則顯示無法獲取資訊
    $result=mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message.");
    if($rs = mysqli_fetch_assoc($result)) {
        //如果有資料則將書名、推薦訊息、作者存入變數，方便後面顯示取用
        $title = $rs['title'];
        $msg = $rs['msg'];
        $author = $rs['author'];
        $language = $rs['language'];
    } else {
        //搜尋不到資訊時, (return row = 0)
        echo "錯誤的推薦書單編號(id)";
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
        <!-- 將推薦書單編號(id)顯示 -->
        <h1>編輯推薦書單: #<?php echo $id;?></h1>
        <form method="post" action="control.php?act=update">
            <!-- 將推薦書單的編號(id)以隱藏的input元素藏在Form裡面送出 -->
            <input type="hidden" name='id' value="<?php echo $id;?>">
            <!-- 將書名帶入input的value中 -->
            Message Title: <input name="title" type="text" id="title" value="<?php echo $title;?>" /> <br>
            <!-- 將推薦訊息帶入input的value中 -->
            Message Body: <input name="msg" type="text" id="msg" value="<?php echo $msg;?>" /> <br>
            <!-- 將作者帶入input的value中 -->
            Author: <input name="author" type="text" id="author" value="<?php echo $author;?>" /> <br>

            Language:
                    <select name="language" id="language">
                        <option value="0" <?php if($language=="0") echo 'selected="selected"'; ?> > 中 </option>
                        <option value="1" <?php if($language=="1") echo 'selected="selected"'; ?> > 英 </option>
                        <option value="2" <?php if($language=="2") echo 'selected="selected"'; ?> > 日 </option>
                        <option value="3" <?php if($language=="3") echo 'selected="selected"'; ?> > 其他 </option>
                    </select><br>

            <input type="submit" name="Submit" value="送出" />
        </form>
    </body>
</html>
