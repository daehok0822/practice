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
            grid-template-columns: 1fr 150px;
            }</style>');
} else {
    $products = array('<style>#login{
            grid-template-columns: 1fr 220px;
            }</style>', '</a><a href="/loginform.php">로그인 </a>', '<a href="/resisterform.php">회원가입 ');
}

$sql = "SELECT * FROM category where parant_id = 0";
$result = mysqli_query($conn, $sql);
$list = '';
while ($row = mysqli_fetch_array($result)) {
    $list .= "<li><a href='index.php?id={$row['id']}'>{$row['name']}</a></li>";
}


$paging = '';
if(empty($_GET['id'])&&empty($_GET['checkbox'])){
    $list3 = '<h2>이곳은 게임 사이트입니다</h2>';
}else{
    include 'paging.php';
}

if(isset($_GET['id'])||isset($_GET['checkbox'])){
    $cat_array = array();
    $cat_message = array('테마', '게임 디자인', '게임 플레이');
    for ($i = 0; $i < 3; $i++) {
        $sql = "SELECT * FROM category where parant_id = {$_GET['id']} and division = $i+1";
        $result = mysqli_query($conn, $sql);
        $list2 = '';
        while ($row = mysqli_fetch_array($result)) {
            $list2 .= '<input type="checkbox" name="checkbox[]" value="' . $row['id'] . '" >' . $row['name'];
        }
        $cat_array[$i] = $cat_message[$i] . '<br>' . $list2;
        if($i==2){
            $cat_array[$i] = $cat_message[$i] . '<br>' . $list2.'<br><input type="submit">';
        }

    }
}

if (isset($_GET['id'])&&empty($_GET['checkbox'])) {
//    $where = "where parant_id = {$_GET['id']}";
    $sql = "SELECT * from article order by id desc" . $sqlLimit;
    $result = mysqli_query($conn, $sql);
    $list3 = '';
    while ($row = mysqli_fetch_array($result)) {
        $list3 .= '<p><h2>' . $row['title'] . '</h2><div class="articlefix"><a href="create.php?id2=' . $row['id'] . '">수정</a>
<form action="delete.php" method="post">
      <input type="hidden" name="id2" value="' . $row['id'] . '">
      <input type="submit" value="삭제">
    </form></div>' . $row['description'] . '</p>';
    }
}


if (isset($_GET['checkbox'])) {
    $sql = "SELECT article.id, title, description FROM article LEFT JOIN art_cat ON article.id = art_id
        LEFT JOIN category ON cat_id = category.id ";
    $where = " where 1=1 ";

    for ($i = 0; $i < count($_GET['checkbox']); $i++) {
        $where .= " and category.id = {$_GET['checkbox'][$i]}";
    }

    $sql .= $where . " order by article.id desc" . $sqlLimit;
    $result = mysqli_query($conn, $sql);
    $list3 = '';
    while ($row = mysqli_fetch_array($result)) {
        $list3 .= '<p><h2>' . $row['title'] . '</h2><div class="articlefix"><a href="create.php?id2=' . $row['id'] . '">수정</a>
<form action="delete.php" method="post">
      <input type="hidden" name="id2" value="' . $row['id'] . '">
      <input type="submit" value="삭제">
    </form></div>' . $row['description'] . '</p>';
    }
}



$Searchlist ='';
$SearchCondition='';
if(isset($_GET['search'])){
    $list3 = '';
    if($_GET['searchWhat']==1){
        $sql = "select * from article where title like '%".$_GET['search']."%'";
        $SearchCondition= '<option value="1" selected="selected">제목</option>
            <option value="2">내용</option>
            <option value="3">제목+내용</option>
            <option value="4">글쓴이</option>';
    } else if($_GET['searchWhat']==2){
        $sql = "select * from article where description like '%".$_GET['search']."%'";
        $SearchCondition= '<option value="1">제목</option>
            <option value="2" selected="selected">내용</option>
            <option value="3">제목+내용</option>
            <option value="4">글쓴이</option>';

    } else if($_GET['searchWhat']==3){
        $sql = "select * from article where title like '%".$_GET['search']."%' or description like '%".$_GET['search']."%'";
        $SearchCondition= '<option value="1">제목</option>
            <option value="2">내용</option>
            <option value="3" selected="selected">제목+내용</option>
            <option value="4">글쓴이</option>';

    } else if($_GET['searchWhat']==4){
        $sql = "select * from article LEFT JOIN user ON user_id = user.id where user.name like '%".$_GET['search']."%'";
        $SearchCondition= '<option value="1">제목</option>
            <option value="2">내용</option>
            <option value="3">제목+내용</option>
            <option value="4" selected="selected">글쓴이</option>';
    }

    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($result)){
        $list3 .='<p><h2>' . $row['title'] . '</h2><div class="articlefix"><a href="create.php?id2=' . $row['id'] . '">수정</a>
    <form action="delete.php" method="post">
          <input type="hidden" name="id2" value="' . $row['id'] . '">
          <input type="submit" value="삭제">
        </form></div>' . $row['description'] . '</p>';
    }


    $Searchlist = '<form id="search_form" action="index.php" method="get">
        <select name="searchWhat">
            '.$SearchCondition.'
        </select>
        <input id="search" type="text" value="'.$_GET['search'].'" name="search" placeholder="검색">
        <input type="button" value="GO" onclick="searchForm()">
    </form>';

} else{

    $Searchlist = '<form id="search_form" action="index.php" method="get">
        <select name="searchWhat">
            <option value="1">제목</option>
            <option value="2">내용</option>
            <option value="3">제목+내용</option>
            <option value="4">글쓴이</option>
        </select>
        <input id="search" type="text" name="search" placeholder="검색">
        <input type="button" value="GO" onclick="searchForm()">
    </form>';
}
?>


<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <script
            src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
            crossorigin="anonymous"></script>
    <style>
        #title h1 {
            font-size: 45px;
            text-align: center;
            margin: 0;
            padding: 20px;

        }
        #title form{
            text-align: right;
            border-bottom: 2px solid gray;
            margin: 0;
        }
        a{
            text-decoration: none;
            color: black;
        }
        #list_border {
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

        .paging ul{
            list-style:none;
            text-align:center;
        }
        .paging li{
            display: inline;
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
        <?php foreach ($products as $item) {
            echo $item . " ";
        }; ?>
    </p>
</div>
<div id="title">
    <h1><a href="index.php">게임 사이트</a></h1>
    <?=$Searchlist?>
</div>
<script>
    function searchForm() {
        if ($('#search').val() == '') {
            alert('검색어를 입력해 주세요');
            return false;
        }
        $('#search_form').submit();
    }
</script>
<div id="page">
    <ul id="list_border">
        <?= $list; ?>
    </ul>
    <div>
        <form action="index.php" method="get">
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
            <?= $cat_array[0] ?? '';?><br>
            <?= $cat_array[1] ?? '';?><br>
            <?= $cat_array[2] ?? '';?><br>
        </form>
        <?= $list3 ?? '';?>

    </div>
</div>
<div class="paging">
    <?php echo $paging ?>
</div>
</body>
</html>
