<?php
  define('TITLE', 'Multiple File Upload Form | WW Project Studio');
  // Create Upload folder
  // mkdir('images', 0777, true);

  if(array_key_exists('upload', $_POST)):
    $dir = 'images/';
    foreach ($_FILES['image']['name'] as $key => $file):
      if(!move_uploaded_file($_FILES['image']['tmp_name'][$key], $dir.$file)):
        die('Can not copy');
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
        <input type="file" name="image[]" multiple>
        <label><small>Max. image size 1.5 MB</small></label>
      </p>
      <button type="submit" name="upload">Submit</button>
    </form>
  </div>
</body>
</html>
