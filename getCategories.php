<?php
include "config.php";

$bigcatid = $_POST['big_id'];   // department id

$sql = "SELECT * FROM category WHERE parant_id =".$bigcatid;

$result = mysqli_query($conn,$sql);

$users_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $id = $row['id'];
    $name = $row['name'];

    $users_arr[] = array("id" => $id, "name" => $name);
}

// encoding array to json format
echo json_encode($users_arr);