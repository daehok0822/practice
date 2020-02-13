<?php
session_start();

include 'connect.php';
$sql = "SELECT * FROM category where parant_id = 0";
$result = mysqli_query($conn, $sql);
$list = '';
while ($row = mysqli_fetch_array($result)) {
    $list .= "<li><a href='index.php?id={$row['id']}'>{$row['name']}</a></li>";
}

$article = array(
    'name'=>'Welcome',
    'description'=>'Hello, web'
);
//if(isset($_GET['id'])){
//    $sql = "SELECT * FROM category where parant_id = {$_GET['id']}";
//    $result = mysqli_query($conn, $sql);
//
//    while ($row = mysqli_fetch_array($result)) {
//        $article['name'] = $row['name'];
//    }
//}
?>


<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <script charset="utf-8" src="/practice.js"></script>
    <style>
        h1 {
            font-size: 45px;
            text-align: center;
            border-bottom: 2px solid gray;
            margin: 0;
            padding: 20px;

        }
        h1,a{
            text-decoration: none;
            color: black;
        }

        ul {
            border-right: 2px solid gray;
            width: 100px;
            height: 1000px;
            margin: 0;
            padding: 20px;
        }

        #login a {

            text-decoration: none;
        }
        #login p{
            margin: 0;
            font-size: 20px;
        }
        #login {
            display: grid;

        }
        #page{
            display: grid;
            grid-template-columns: 150px 1fr;
        }
    </style>
</head>
<body>
<div id="login">
    <p>
    <?php
    if (isset($_SESSION['is_login'])) {
        echo $_SESSION["name"] . " 님 환영합니다";
    } else {
        echo "로그인 또는 회원가입이 필요합니다";
    }
    ?></p>

    <p>
        <a href="./create.php">글쓰기</a>
        <a href="./logout.php">글수정</a>
        <a href="./logout.php">글삭제</a>
        <?php
        if (isset($_SESSION['is_login'])) {
            echo '<a href="./logout.php">로그아웃 </a>';
            echo "<style>#login{
            grid-template-columns: 1fr 300px;
            }</style>";
        } else {
            echo '<a href="/form.php">회원가입 ';
            echo '</a><a href="/loginform.php">로그인 </a>';
            echo "<style>#login{
            grid-template-columns: 1fr 350px;
            }</style>";
        }
        ?>
    </p>
</div>
<h1><a href="index.php">게임 사이트</a></h1>
<div id="page">
    <ul>
        <?= $list; ?>
    </ul>
    <div>
    <h2>게임이름</h2>
    <p>내용</p>
    </div>
</div>
</body>
</html>
