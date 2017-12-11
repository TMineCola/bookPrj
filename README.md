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
    Model -> 負責跟DB要求資料
    Controller -> 負責所有功能及邏輯
    View -> 使用者看得到的介面
```
### Login相關
- [View] loginForm.php: 登入頁面, 將帳密以Post的方式送至loginControl.php處理
- [Controller] loginControl.php: 處理登入及帳號相關Request(請求)
- [Model] loginModel.php: 包含檢查帳號密碼、判斷是否為管理員、讀取使用者ID的功能

### 推薦書單相關
- [View] view.php: 全部推薦書單的頁面, 包含推薦書單的新增、刪除、修改、按讚連結, 除了顯示全部的推薦書單之外, 會將新的推薦書單資訊以Post的方式送至control.php處理
- [View] viewDetail.php: 依據Get的id顯示該推薦書單的內容及針對該推薦書單的回應(Comment), 包含推薦書單的刪除、修改、按讚連結
- [Controller] control.php: 處理推薦書單的新增、刪除、修改、按讚及回應的新增、刪除相關Request(請求)
- [Model] model.php: 包含新增、刪除、修改、按讚及新增、刪除的功能


## Debug Q & A
### Q1:
```
Warning: mysqli_connect(): (HY000/1045): Access denied for user 'root'@'localhost' (using password: YES) in /Applications/XAMPP/xamppfiles/htdocs/Mid/**dbconnect.php** on line 11
Error with MySQL connection
```
### A1:
```
[dbconnect.php] 使用者的帳號或密碼錯誤, 到 ＤＢ 檢查看看使用者帳號及密碼有沒有輸入正確(也可以重設密碼)
```
---
### Q2:
```
Warning: mysqli_connect(): (HY000/1049): Unknown database 'XXXX' in /Applications/XAMPP/xamppfiles/htdocs/Mid/**dbconnect.php** on line 11
Error with MySQL connection
```
### A2:
```
[dbconnect.php] 資料庫設定錯誤, 去檢查檔案裡面 db = '';的位置是不是設定到正確的DB
```
---
### Q3:
```
Notice: A session had already been started - ignoring session_start() in /Applications/XAMPP/xamppfiles/htdocs/Mid/loginModel.php on line 3
```
### A3:
```
[loginModel.php] 在引入(require)php的時候可能有兩次session_start();
簡單來說假設你今天頁面已經有session_start();如果再次require另外一個包含session_start();就會噴錯
但是不影響執行結果
```
---

## Contributors
- Project Owner sdbook (via Fork)
- MineCola
