<?php
include 'connect.php';
$result = mysqli_query($conn,"
            INSERT INTO user (
                `name`,
                `password`
            ) values (
                '{$_POST['name']}',
                '" . $_POST['password'] . "'
            )");
echo "<script>location.href='/login.php';</script>";

