<?php
session_start();
include 'connect.php';

$sql = "
  INSERT INTO article
    (user_id, title, description, pub_date)
    VALUES(
        '".$_SESSION['id']."',
        '{$_POST['title']}',
        '{$_POST['description']}',
        NOW()
    )
";
$result = mysqli_query($conn, $sql);
if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
    error_log(mysqli_error($conn));
} else {
    echo '성공했습니다. <a href="index.php">돌아가기</a>';
    $last_uid = mysqli_insert_id($conn);
    foreach ($_POST['cat_id'] as $item) {
        $sql = "
      INSERT INTO art_cat(art_id, cat_id)
      VALUES($last_uid, $item)";
        $result = mysqli_query($conn, $sql);
    }

}




