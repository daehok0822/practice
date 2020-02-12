<?php
session_start();

$conn = mysqli_connect("localhost", "root", "wlghcjs1", "practice");
$name = $_POST['name']; // 아이디
$password = $_POST['password']; // 패스워드

$query = "select * from user where name='{$name}' and password='{$password}'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
if($name==$row['name'] && $password==$row['password']) {
    echo "<script>alert(\"로그인 성공\");</script>";
    $_SESSION['name'] = $name;
    $_SESSION['is_login'] = true;
    echo "<script>location.href='/index.php';</script>";
} else {
    echo "<script>alert(\"아이디 혹은 비밀번호가 틀렸습니다\");</script>";
    echo "<script>location.href='/loginform.php';</script>";
}
//        $result = mysqli_query($conn, $query);
//        $row = mysqli_fetch_array($result);




