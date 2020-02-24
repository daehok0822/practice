<?php
session_start();
include 'connect.php';
if($_POST['id2']){
    $sql = "
  UPDATE article
    SET
      title = '{$_POST['title']}',
      description = '{$_POST['description']}'
    WHERE
      id = {$_POST['id2']}
";
}else{
    $sql = "
      INSERT INTO article
        (user_id, title, description, pub_date)
        VALUES(
            '".$_SESSION['id']."',
            '{$_POST['title']}',
            '{$_POST['description']}',
            NOW()
        )
    ";}

$result = mysqli_query($conn, $sql);
if($result === false){
    echo '저장하는 과정에서 문제가 생겼습니다. 관리자에게 문의해주세요';
    error_log(mysqli_error($conn));
} else {
    echo '성공했습니다. <a href="index.php">돌아가기</a>';

    if ($_POST['id2']) {
//        foreach ($_POST['cat_id'] as $item) {
//            $sql = "UPDATE art_cat SET cat_id ='$item' where art_id = {$_POST['id2']}";
//            $result = mysqli_query($conn, $sql);
//        }
        $sql = "DELETE FROM art_cat WHERE art_id = {$_POST['id2']}";
        $result = mysqli_query($conn, $sql);
        foreach ($_POST['cat_id'] as $item) {
            $sql = "INSERT INTO art_cat(art_id, cat_id) VALUES({$_POST['id2']}, $item)";
            $result = mysqli_query($conn, $sql);
        }
    } else {
        $last_uid = mysqli_insert_id($conn);
        foreach ($_POST['cat_id'] as $item) {
            $sql = "INSERT INTO art_cat(art_id, cat_id) VALUES($last_uid, $item)";
            $result = mysqli_query($conn, $sql);
        }
    }

}




