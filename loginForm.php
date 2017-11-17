<?php
    session_start();
    //將使用者的登入狀態設為 0
    $_SESSION['uID'] = 0;
?>
<h1>登入系統</h1><hr />
<!-- 將使用者的帳密以post的方式送至 loginControl.php 進行處理 -->
<form method="post" action="loginControl.php">
    <input type="hidden" name="act" value="login">
    帳號: <input type="text" name="id"><br />
    密碼 : <input type="password" name="pwd"><br />
    <input type="submit">
</form>