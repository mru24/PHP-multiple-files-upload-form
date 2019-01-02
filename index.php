<?php
  define('TITLE', 'Multiple File Upload Form | WW Project Studio');
  // Create Upload folder
  // mkdir('images', 0777, true);
  $success = false;
  $fail = false;
  $msg = '';

  if(array_key_exists('upload', $_POST)):
    // print_r($_FILES);
    $dir = 'images/';
    $sub = $_POST['subfolder'].'/';
    $permitted = array(
      'image/gif',
      'image/jpeg',
      'image/pjpeg',
      'image/png'
    );
    $dirOK = false;
    $sizeOK = false;
    $typeOK = false;

    // Check folder and subfolder
    if(!file_exists($dir . $sub)):
      if(!mkdir($dir . $sub, 0777, true)):
        die('Failed to create folder');
      endif;
    else:
      $dirOK = true;
    endif;

    foreach ($_FILES['image']['name'] as $key => $file):
      // replace any spaces with underscores
      $file = str_replace(' ', '_', $file);
      // check if image size is less than 1.5 MB
      $filesize = $_FILES['image']['size'][$key];

      if($filesize > 10 && $filesize < 1572864):
        $sizeOK = true;
      endif;
      // check for permitted image type
      foreach ($permitted as $type):
        if($type == $_FILES['image']['type'][$key]):
          $typeOK = true;
          break;
        endif;
      endforeach;

      if(!$sizeOK):
        $fail = true;
        $msg = 'Image size must be less than 1.5 MB';
      else:
        if(!$typeOK):
          $fail = true;
          $msg = 'Acceptable file types: gif, jpg, png';
        else:
          if(!move_uploaded_file($_FILES['image']['tmp_name'][$key], $dir . $sub . $file)):
            die('Failed to copy files');
          else:
            $success = true;
            $msg = 'Files copied';
          endif;
        endif;
      endif;
    endforeach;
  endif;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo TITLE; ?></title>
    <link rel="stylesheet" href="css/style.min.css">
</head>
<body>
  <div id="demo">
    <form action="" method="post" enctype="multipart/form-data">
      <h2 class="title">Multiple Files Upload Form</h2>
      <p>
        <select name="subfolder">
          <option value="cats">cats</option>
          <option value="cars">cars</option>
          <option value="computers">computers</option>
        </select>
      </p>
      <p>
        <input type="file" name="image[]" multiple>
        <label><small>Max. image size 1.5 MB</small></label>
      </p>
      <button type="submit" name="upload">Submit</button>
    </form>
<?php
if($success):
?>
<div class="success">
  <h2 class="msg"><?php echo $msg; ?></h2>
</div>
<?php
endif;
if($fail):
?>
<div class="fail">
  <h2 class="msg"><?php echo $msg; ?></h2>
</div>
<?php
endif;
?>
  </div>
</body>
</html>
