<?php
include 'connect.php';
session_start();

if (empty($_SESSION['is_login'])) {
//header('Location: ./loginform.php');
    ?>
    <script>
        alert('로그인 해 주세요');
        location.href = 'loginform.php';
    </script>
    <?php
    exit;
}

$sql = "DELETE FROM article WHERE id = {$_POST['id2']}";
$result = mysqli_query($conn, $sql);

$result = mysqli_query($conn, $sql);
if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
    error_log(mysqli_error($conn));
} else {
    echo '성공했습니다. <a href="index.php">돌아가기</a>';
}