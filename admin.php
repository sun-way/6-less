<?php
require_once('./config.php');
require_once('./getFileList.php');
if (isset($_FILES['testfile']) && !empty($_FILES['testfile'])) {
    $fileType = $_FILES['testfile']['type'];
    $tmpPath = $_FILES['testfile']['tmp_name'];
    if ($fileType !== 'application/json') {
        exit('File not instance of json. Please upload another file.');
    }
    $id = getFileList(['targetDir' => $testsDir, 'returnCount' => true]);
    $fileName = 'id' . ++$id . '.json';

    move_uploaded_file($tmpPath, $testsDir . $fileName);
    echo 'File did upload';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tests uploader</title>
</head>
<body>

<form action="./admin.php" method="POST" enctype="multipart/form-data">
    <label>
        <div>Выберите файл:</div>
        <div><input name="testfile" type="file" accept="application/json"></div>
    </label>

    <div>
        <button type="submit">
            Отправить
        </button>
    </div>
</form>


<style>
    div {
        padding: 10px 0;
    }
</style>

</body>
</html>