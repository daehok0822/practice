<?php
session_start();
include 'connect.php';
if (isset($_SESSION['is_login'])) {
    $login_text = $_SESSION["name"] . " 님 환영합니다";
} else {
    $login_text = "로그인 또는 회원가입이 필요합니다";
}

if (isset($_SESSION['is_login'])) {
    $products = array('<a href="./logout.php">로그아웃 </a>', '<style>#login{
            grid-template-columns: 1fr 300px;
            }</style>');
} else {
    $products = array('<style>#login{
            grid-template-columns: 1fr 350px;
            }</style>', '</a><a href="/loginform.php">로그인 </a>', '<a href="/form.php">회원가입 ');
}

$sql = "SELECT * FROM category where parant_id = 0";
$result = mysqli_query($conn, $sql);
$list = '';
while ($row = mysqli_fetch_array($result)) {
    $list .= "<li><a href='index.php?id={$row['id']}'>{$row['name']}</a></li>";
}

if(isset($_GET['id'])){

//    $where = "where parant_id = {$_GET['id']}";
    $cat_array = array();
    $cat_message = array('테마','게임 디자인','게임 플레이');
    for ($i = 0; $i < 3; $i++){
        $sql = "SELECT * FROM category where parant_id = {$_GET['id']} and division = $i+1";
        $result = mysqli_query($conn, $sql);
        $list2 = '';
        while ($row = mysqli_fetch_array($result)) {
            $list2 .= '<input type="checkbox" name="checkbox[]" value="'.$row['id'].'" >'.$row['name'];
        }
        $cat_array[$i] = $cat_message[$i].'<br>'.$list2;
    }




}
if(isset($_POST['checkbox'])) {
    $sql = "SELECT article.
id, title, description FROM article LEFT JOIN art_cat ON article.id = art_id
        LEFT JOIN category ON cat_id = category.id ";
    $where = " where 1=1 ";

    for ($i = 0; $i < count($_POST['checkbox']); $i++) {
        $where .= " and category.id = {$_POST['checkbox'][$i]}";
    }

    $sql .= $where;
    $result = mysqli_query($conn, $sql);
    $list3 = '';
    while ($row = mysqli_fetch_array($result)) {
        $list3 .= '<p><h2>'.$row['title']."</h2><div class='articlefix'><a href='create.php?id2={$row['id']}'>글수정</a></div>". $row['description'].'</p>';
    }
}
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
        .articlefix{
            text-align:right;
        }

    </style>
</head>
<body>
<div id="login">
    <p>
        <?= $login_text; ?>
    </p>
    <p>
        <a href="./create.php">글쓰기</a>
        <a href="./update.php">글수정</a>
        <a href="./logout.php">글삭제</a>
        <?php foreach ($products as $item) {
            echo $item . " ";
        }; ?>
    </p>
</div>
<h1><a href="index.php">게임 사이트</a></h1>
<div id="page">
    <ul>
        <?= $list; ?>
    </ul>
    <div>
        <form action="index.php" method="post">
            <?= $cat_array[0] ?? '';?><br>
            <?= $cat_array[1] ?? '';?><br>
            <?= $cat_array[2] ?? '';?><br>
            <input type="submit">
        </form>
        <?= $list3 ?? '';?>
    </div>
</div>
</body>
</html>
