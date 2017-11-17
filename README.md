軟體工程期中考 - 推薦書單
===

## How to Install
1. Clone到你的本機
2. 打開XAMPP
3. 將SQL資料中的.sql檔案匯入DB, (請先點選一個DB再按上方“匯入”選取.sql檔上傳至資料庫)
4. 設定SQL連線資訊 (dbconnect.php)
5. 打開網頁輸入127.0.0.1

## Arch of Project
```
本專案採MVC架構 （Model–view–controller），在軟體設計中可以簡化架構複雜度，讓修改或新增新功能都能夠更簡易的進行。
    Model -> 功能(函式庫)
    Controller -> 負責處理Request並對應請求呼叫相關的函式功能
    View -> 使用者看得到的介面
```

## Debug Q & A
### Q1:
```
Warning: mysqli_connect(): (HY000/1045): __Access denied for user 'root'@'localhost' (using password: YES)__ in /Applications/XAMPP/xamppfiles/htdocs/Mid/**dbconnect.php** on line 11
Error with MySQL connection
```
### A1:
```
[dbconnect.php] 使用者的帳號或密碼錯誤, 到 phpmyadmin 檢查看看使用者帳號及密碼有沒有輸入正確(也可以重設密碼)
```
---
### Q2:
```
Warning: mysqli_connect(): (HY000/1049): **Unknown database 'XXXX'** in /Applications/XAMPP/xamppfiles/htdocs/Mid/**dbconnect.php** on line 11
Error with MySQL connection
```
### A2:
```
[dbconnect.php] 資料庫設定錯誤, 去檢查檔案裡面 db = '';的位置是不是設定到正確的DB
```


## Contributors
- Project Owner sdbook (via Fork)
- MineCola