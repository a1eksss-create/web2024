<?php

function saveLog() {
    $logFolder = 'logs';
    $logPath = "$logFolder/log.txt";
    
    if (!file_exists($logFolder)) {
        mkdir($logFolder, 0777);
    }
    
    $now = date('Y-m-d H:i:s');
    $logLine = "Request at: $now\n";
    
    $logLines = file_exists($logPath) ? file($logPath) : [];
    if (count($logLines) >= 10) {
        $fileNum = 0;
        while (file_exists("$logFolder/log$fileNum.txt")) {
            $fileNum++;
        }
        rename($logPath, "$logFolder/log$fileNum.txt");
        file_put_contents($logPath, '');
    }
    
    file_put_contents($logPath, $logLine, FILE_APPEND);
}
saveLog();

$msg = '';
if (isset($_FILES['image'])) {
    $imgFolder = 'images';
    $thumbFolder = 'thumbnails';
    $maxFileSize = 5 * 1024 * 1024;
    $okTypes = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (!file_exists($imgFolder)) mkdir($imgFolder, 0777);
    if (!file_exists($thumbFolder)) mkdir($thumbFolder, 0777);
    
    $file = $_FILES['image'];
    $fileName = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($file['name']));
    $fileName = substr($fileName, 0, 50);
    $fileType = mime_content_type($file['tmp_name']);
    $fileSize = $file['size'];
    
    if (!in_array($fileType, $okTypes)) {
        $msg = 'Только JPEG, PNG или GIF';
    } elseif ($fileSize > $maxFileSize) {
        $msg = 'Файл больше 5Mb';
    } else {
        $imgPath = "$imgFolder/$fileName";
        if (move_uploaded_file($file['tmp_name'], $imgPath)) {
            $thumbPath = "$thumbFolder/thumb_$fileName";
            if (makeThumb($imgPath, $thumbPath, 200, 200)) {
                $msg = 'Картинка загружена';
                header('Location: index.php');
                exit;
            } else {
                $msg = 'Ошибка при создании миниатюры';
            }
        } else {
            $msg = 'Ошибка при загрузке';
        }
    }
}

function makeThumb($src, $dst, $maxW, $maxH) {
    $thumbDir = dirname($dst);
    if (!file_exists($thumbDir)) {
        mkdir($thumbDir, 0777, true);
    }
    
    list($w, $h, $type) = getimagesize($src);
    
    if ($type == IMAGETYPE_JPEG) {
        $img = imagecreatefromjpeg($src);
    } elseif ($type == IMAGETYPE_PNG) {
        $img = imagecreatefrompng($src);
    } elseif ($type == IMAGETYPE_GIF) {
        $img = imagecreatefromgif($src);
    } else {
        return false;
    }
    
    $scale = min($maxW / $w, $maxH / $h);
    $newW = (int)($w * $scale); 
    $newH = (int)($h * $scale);
    
    $newImg = imagecreatetruecolor($newW, $newH);
    
    if ($type == IMAGETYPE_PNG) {
        imagealphablending($newImg, false);
        imagesavealpha($newImg, true);
    }
    
    imagecopyresampled($newImg, $img, 0, 0, 0, 0, $newW, $newH, $w, $h);
    
    $result = false;
    if ($type == IMAGETYPE_JPEG) {
        $result = imagejpeg($newImg, $dst);
    } elseif ($type == IMAGETYPE_PNG) {
        $result = imagepng($newImg, $dst);
    } elseif ($type == IMAGETYPE_GIF) {
        $result = imagegif($newImg, $dst);
    }
    
    imagedestroy($img);
    imagedestroy($newImg);
    return $result;
}

function showGallery($imgFolder, $thumbFolder) {
    $exts = ['jpg', 'jpeg', 'png', 'gif'];
    $pics = [];
    
    if (file_exists($imgFolder)) {
        $files = scandir($imgFolder);
        foreach ($files as $file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($ext, $exts)) {
                $cleanFile = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file);
                $cleanFile = substr($cleanFile, 0, 50);
                if ($cleanFile != $file) {
                    rename("$imgFolder/$file", "$imgFolder/$cleanFile");
                    $file = $cleanFile;
                }
                $pics[] = $file;
                $thumb = "$thumbFolder/thumb_$file";
                if (!file_exists($thumb)) {
                    makeThumb("$imgFolder/$file", $thumb, 200, 200);
                }
            }
        }
    }?>
    
    <div class="gallery"> <?php
    foreach ($pics as $pic):
        $thumb = "$thumbFolder/thumb_$pic";
        if (file_exists($thumb)) {
            echo "<a href='$imgFolder/$pic' target='_blank'><img src='$thumb' width='200'></a>";
        }
    endforeach; ?>
    </div> <?php
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Галерея</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Галерея</h1>
    
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*" required>
        <input type="submit" value="Загрузить">
    </form>
    
    <?php if ($msg): ?>
        <p><?= $msg; ?></p>
    <?php endif; ?>
    
    <?php showGallery('images', 'thumbnails'); ?>
</body>
</html>