<?php 
function getFileList($options) {
    if (!isset($options)) {
      exit('Options not transferred');
    } elseif (empty($options)) {
      exit('Options empty');
      
    } elseif (empty($options['targetDir'])) {
      exit('Wrong target dir');
    }
    $targetDir = $options['targetDir'];
    $returnCount = $options['returnCount'];
    $dir = opendir($targetDir);
    $list = [];
    while($file = readdir($dir)){
        if($file == '.' || $file == '..' || is_dir($targetDir . $file)){
            continue;
        }
        $list[] = $file;
    }
    if ($returnCount) {
      return count($list);
    }
    return $list;
}
?>
