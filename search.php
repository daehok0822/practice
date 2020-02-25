<?php

if(isset($_GET['search'])){
    $list3 = '';
    if($_GET['searchWhat']==1){
        $sql = "select * from article where title like '%".$_GET['search']."%'";
    } else if($_GET['searchWhat'==2]){
        $sql = "select * from article where description like '%".$_GET['search']."%'";
        $result = mysqli_query($conn,$sql);
    } else if($_GET['searchWhat'==3]){
        $sql = "select * from article where title like '%".$_GET['search']."%' or description like '%".$_GET['search']."%'";
        $result = mysqli_query($conn,$sql);
    } else if($_GET['searchWhat'==4]){
        $sql = "select * from article LEFT JOIN user ON user_id = user.id where user.name like '%".$_GET['search']."%'";
        $result = mysqli_query($conn,$sql);
    }

    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($result)){
        $list3 .='<p><h2>' . $row['title'] . '</h2><div class="articlefix"><a href="create.php?id2=' . $row['id'] . '">수정</a>
    <form action="delete.php" method="post">
          <input type="hidden" name="id2" value="' . $row['id'] . '">
          <input type="submit" value="삭제">
        </form></div>' . $row['description'] . '</p>';
    }
}

