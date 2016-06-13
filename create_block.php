<?php
include "conn.php";
$uptypes=array(
'image/png'
);
$max_file_size=2000000; //上傳檔案大小限制, 單位BYTE
 
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<head>
  <title>Blockly Demo: Generating DIPS</title>
  <script src="blockly_compressed.js"></script>
  <script src="blocks_compressed.js"></script>
  <script src="dips_blockly.js"></script>
  <script src="dips.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <style>
    body {
      background-color: #fff;
      font-family: sans-serif;
      margin-left: 20px;
    }
    h1 {
      font-weight: normal;
      font-size: 140%;
    }
    .container {
      float: left;
      width: 400px;
    }
    .red {
      color: red;
    }

  </style>
</head>
<body>
  <h1>Create Block</h1>
  <p>This is a way to create blocks for generating code.</p>
  <!-- <div class="container"> -->
  <form enctype="multipart/form-data" method="post" name="upform" action="create_block.php">
  <div class="container">
  <table class="table">
  <tr>
  <div class="form-group">
    <input class="btn btn-default" type="button" onclick="location='/'" value="回首頁" />
  </div>
  </tr>
  <tr> 
    <div class="form-group">
    <label for="usr">Attribute:</label>
    <select class="form-control" id="attr" name="attr">
      <option value="0">Please select one attribute to add.</option>
      <option value="1">Trigger</option>
      <option value="2">Action</option>
    </select>
    </div>
  </tr>
  <tr> 
    <div class="form-group">
      <label for="usr">Name:</label>
      <input type="text" class="form-control" name="name" required>
    </div>
  </tr>
  <tr>
    <div class="form-group">
      <label for="usr">Image:</label>
      允許上傳的檔案類型為: <span class="red"><?php echo implode(',',$uptypes)?></span>
      <input class="form-control" id="focusedInput" name="upfile" type="file" required>
    </div>
  </tr>
  <tr>
    <input class="btn btn-default" type="submit" name="submit" value="上傳">
  </tr>
  </table>
  </div>
  </form>
  <!-- </div> -->

  <?php
    if(isset($_POST['submit']))
    // if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      if (!is_uploaded_file($_FILES["upfile"]['tmp_name']))
      //是否存在檔案
      {
      echo "<p class='red'>您還沒有選擇檔!</p>";
      exit;
      }


      $file = $_FILES["upfile"];
      if($max_file_size < $file["size"])
      //檢查檔案大小
      {
      echo "<p class='red'>您選擇的檔太大了!</p>";
      exit;
      }

      if(!in_array($file["type"], $uptypes))
      //檢查檔案類型
      {
      echo "<p class='red'>檔案類型不符!</p>";
      exit;
      }

      move_uploaded_file($_FILES['upfile']['tmp_name'],'media/image/'.$_FILES['upfile']['name']);
      
      $filename = $file["name"];
      $attr = $_POST['attr'];
      switch ((int)$attr) {
        case 1:
          $attri = "Trigger";
          break;
        case 2:
          $attri = "Action";
          break;  
        default:
          echo "<script>location='create_block.php';alert('屬性未選喔，請重新上傳!');</script>";
          break;
      }
      $name = $_POST['name'];

      // echo "file" . $filename . " attri " . $attri . "name " . $name;
    try { 
      $sql_check = "INSERT INTO workspace (name, image, attr) VALUES (?,?,?) ON DUPLICATE KEY UPDATE name=?, image=?, attr=?";
      $stmt = $conn->prepare($sql_check);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $filename);
            $stmt->bindValue(3, $attri);
            $stmt->bindValue(4, $name);
            $stmt->bindValue(5, $filename);
            $stmt->bindValue(6, $attri);
            $stmt->execute();
    } catch(Exception $e) {
      // die(var_dump($e));
        echo "<script>location='create_block.php';alert('格式有錯喔，請重新上傳!');</script>";
      }
      echo "<script>location='/';alert('新增成功!');</script>";
    }
  ?>



</body>
</html>
