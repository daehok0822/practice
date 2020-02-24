<?php
include 'connect.php';
$sql = "SELECT name FROM user";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    if($row['name']===$_POST['name']){
        ?>
        <script>
        alert('이미 사용중인 아이디입니다');
        location.href = 'resisterform.php';
        </script>
        <?php
        exit;
    }
};
mysqli_query($conn,"
            INSERT INTO user (
                `name`,
                `password`
            ) values (
                '{$_POST['name']}',
                '" . $_POST['password'] . "'
            )");
echo "<script>location.href='/login.php';</script>";

