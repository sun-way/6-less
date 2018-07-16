<?php 
require_once('./config.php');
require_once('./getFileList.php');
$list = getFileList(['targetDir' => $testsDir]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Test list</title>
</head>
<body>

  <h1>Список тестов:</h1>
  
  <ul>
    <?php foreach($list as $filename): ?>
      <li><?php echo $filename ?></li>
    <? endforeach ?>
  </ul>

</body>
</html>
