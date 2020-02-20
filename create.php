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
$sql = "SELECT title, description FROM article where id = {$_GET['id2']}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
if(isset($_GET['id2'])){
/*    ?>
<input type="ddd" value="<?=$row['title']?>">
<?php
*/
    $text ='<p><input type="text" name="title" value="'.$row['title'].'"></p>
    <p><textarea name="description">'.$row['description'].'</textarea></p>
     <input type="hidden" name="id2" value="'.$_GET['id2'].'">';

} else{
    $text ='<p><input type="text" name="title" placeholder="title"></p>
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

<select id="big_cat">
    <option value="0">- Select -</option>
    <?php
    // Fetch Department
    $sql = "SELECT * FROM category where parant_id = 0";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result) ){
        $id = $row['id'];
        $name = $row['name'];

        // Option
        echo "<option value='".$id."' >".$name."</option>";
    }
    ?>
</select>


<form action="process_create.php" method="POST">
    <p><select id="small_cat" name="cat_id[]" multiple="multiple">
            <option value="0">- Select -</option>
        </select></p>
    <?= $text; ?>
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
                        //append 뒤와 value 뒤 문자열을 모두 챙기려니 이꼬라지
                    }
                }
            });
        });
    });
</script>
</body>
</html>