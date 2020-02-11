<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <script charset="utf-8" src="/practice.js" ></script>
</head>
<body>
4343434
    <?php
        $conn = mysqli_connect("localhost", "root", "wlghcjs1", "practice");

        $sql = "
            INSERT INTO user (
                `name`,
                `password`
            ) values (
                '{$_POST['name']}',
                '" . $_POST['password'] . "'
            )";
        $result = mysqli_query($conn,"
            INSERT INTO user (
                `name`,
                `password`
            ) values (
                '{$_POST['name']}',
                '" . $_POST['password'] . "'
            )");
        var_dump($result);
    var_dump($conn);
    ?>
</body>
</html>