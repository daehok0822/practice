<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
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

        ul {
            border-right: 2px solid gray;
            width: 100px;
            height: 1000px;
            margin: 0;
            padding: 20px;
        }

        #login a {
            font-size: 20px;
            text-decoration: none;

        }

        #login {
            text-align: right;
            display: inline;
        }
        #a{
            display: inline;
        }

    </style>
</head>
<body>
<div id="a">
    <?php
    if (isset($_SESSION['is_login'])) {
        echo $_SESSION["name"] . " 님 환영합니다";
    } else {
        echo "로그인 또는 회원가입이 필요합니다";
    }
    ?>
</div>

<div id="login">
    <p><a href="/form.php">회원가입 </a><a href="/loginform.php">로그인 </a><a href="./logout.php">로그아웃 </a>
    </a><a href="./create.php">글쓰기 </a></a><a href="./logout.php">글수정 </a></a>
    <a href="./logout.php">글삭제</a></p>
</div>
<h1>게임 사이트</h1>
<ul>
    <li>게임</li>
    <li>보드게임</li>
</ul>

</body>
</html>
