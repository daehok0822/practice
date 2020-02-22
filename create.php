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



$bigcatSellect = '';
$sql = "SELECT * FROM category where parant_id = 0"; //아이디 값이 0번인 대분류
$result_category = mysqli_query($conn,$sql);
if(isset($_GET['id2'])){ //글수정이라면
/*    ?>
<input type="ddd" value="<?=$row['title']?>">
<?php
*/

    $sql = "SELECT * FROM art_cat a JOIN category c ON a.cat_id = c.id where art_id = {$_GET['id2']}"; //수정하려는 글의 대분류, 중분류 값 가져오기
    $result = mysqli_query($conn, $sql);
    $small_cat = array();
    while ($row = mysqli_fetch_array($result)){
        array_push($small_cat, "{$row['cat_id']}");//중분류값을 배열에 저장
        $big_cat = $row['parant_id'];//대분류 값 저장
    }



    $sql = "SELECT * FROM category WHERE parant_id =".$big_cat; //현재 대분류에 해당하는 중분류 값을 가져옴
    $result = mysqli_query($conn,$sql);
//    $users_arr = array();
    $list = '';
    while($row = mysqli_fetch_array($result) ){
//        $users_arr[] = array("id" => $id, "name" => $name);

        $bool = true;
        if(in_array($row['id'], $small_cat)){
            $list .= "<option value='" . $row['id'] . "' selected='selected' >" . $row['name'] . "</option>\n";
        } else{
            $list .= "<option value='" . $row['id'] . "' >" . $row['name'] . "</option>\n";
        }


    }


    while($row = mysqli_fetch_assoc($result_category) ) {

        if ($big_cat === $row['id']) {
            $bigcatSellect.= "<option value='" . $row['id'] . "' selected='selected'>" . $row['name'] . "</option>";
        } else {
            $bigcatSellect.= "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
        }
    }


    $sql = "SELECT title, description FROM article where id = {$_GET['id2']}"; //수정하려는 글을 가져옴
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $smallcatSellect ='<p><select name="cat_id[]" multiple="multiple">
            <option value="0">- Select -</option>
            '.$list.'
        </select></p>
        <p><input type="text" name="title" value="'.$row['title'].'"></p>
    <p><textarea name="description">'.$row['description'].'</textarea></p>
     <input type="hidden" name="id2" value="'.$_GET['id2'].'">';


} else {

    while($row = mysqli_fetch_assoc($result_category) ) {
        $bigcatSellect.= "<option value='" . $row['id'] . ">" . $row['name'] . "</option>";
    }

    $smallcatSellect ='<p><select id="small_cat" name="cat_id[]" multiple="multiple">
            <option value="0">- Select -</option>
        </select></p>
        <p><input type="text" name="title" placeholder="title"></p>
    <p><textarea name="description" placeholder="description"></textarea></p>';
}






?>
<!doctype html>
<html>
<head>
    <script
            src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
            crossorigin="anonymous"></script>
    <meta charset="utf-8">
</head>
<body>
<form action="process_create.php" method="POST">

<select id="big_cat">
    <option value="0">- Select -</option>
    <?= $bigcatSellect;?>
</select>

    <?= $smallcatSellect; ?>
    <p><input type="submit"></p>
</form>

<script>
    $(document).ready(function(){
        $("#big_cat").change(function(){
            var deptid = $(this).val(); //대분류의 아이디값 전달 1또는 2
            $.ajax({
                url: 'getCategories.php',
                type: 'post',
                data: {big_id:deptid},
                dataType: 'json',
                success:function(response){

                    var len = response.length;
                    $("#small_cat").empty();
                    for( var i = 0; i<len; i++){
                        var id = response[i]['id'];
                        var name = response[i]['name'];

                        $("#small_cat").append("<option value='"+id+"'>"+name+"</option>");
                    }
                }
            });
        });
    });
</script>
</body>
</html>