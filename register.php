<?php
$conn = mysqli_connect("localhost", "root", "wlghcjs1", "practice");
$result = mysqli_query($conn,"
            INSERT INTO user (
                `name`,
                `password`
            ) values (
                '{$_POST['name']}',
                '" . $_POST['password'] . "'
            )");
echo "<script>location.href='/rogin.php';</script>";

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <script charset="utf-8" src="/practice.js" ></script>
</head>
<body>

</body>
</html>