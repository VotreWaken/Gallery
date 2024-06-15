<?php
header('Content-Type: application/json');

$response = ['message' => '', 'type' => ''];

if (isset($_POST['slider_select']) && isset($_FILES['images'])) {
    $slider = $_POST['slider_select'];
    $original_dir = 'images/' . $slider . '/original/';
    $thumbnail_dir = 'images/' . $slider . '/small/';
    
    if (!is_dir($original_dir)) {
        mkdir($original_dir, 0777, true);
    }
    if (!is_dir($thumbnail_dir)) {
        mkdir($thumbnail_dir, 0777, true);
    }

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['images']['name'][$key];
        $file_tmp = $_FILES['images']['tmp_name'][$key];
        $original_path = $original_dir . $file_name;

        move_uploaded_file($file_tmp, $original_path);

        addWatermark($original_path, "images/watermark.png", $original_dir);

        $thumbnail_path = $thumbnail_dir . 'thumb_' . $file_name;
        create_thumbnail($original_path, $thumbnail_path, 150, 150);
    }
    $response['message'] = "Изображения загружены успешно.";
    $response['type'] = 'success';
} else {
    $response['message'] = "Ошибка загрузки изображений.";
    $response['type'] = 'danger';
}

echo json_encode($response);

function addWatermark($sourceImagePath, $watermarkImagePath, $outputImagePath)
{
  extract(pathinfo($sourceImagePath));
  $functionCreate = 'imagecreatefrom' . ($extension === 'jpg' ? 'jpeg' : $extension);
  $image = $functionCreate($sourceImagePath);
  $watermark = imagecreatefrompng($watermarkImagePath);

  $imageWidth = imagesx($image);
  $imageHeight = imagesy($image);
  $watermarkWidth = imagesx($watermark);
  $watermarkHeight = imagesy($watermark);

  $destX = $imageWidth - $watermarkWidth - 10;
  $destY = $imageHeight - $watermarkHeight - 10;

  imagecopy($image, $watermark, $destX, $destY, 0, 0, $watermarkWidth, $watermarkHeight);

  $functionSave = 'image' . ($extension === 'jpg' ? 'jpeg' : $extension);
  if (!file_exists($outputImagePath)) {
    mkdir($outputImagePath);
  }
  $functionSave($image, "$outputImagePath/$basename");

  imagedestroy($image);
  imagedestroy($watermark);
}

function create_thumbnail($src, $dest, $desired_width, $desired_height) {
    $source_image = imagecreatefromjpeg($src);
    $width = imagesx($source_image);
    $height = imagesy($source_image);
    
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
    
    imagejpeg($virtual_image, $dest);
}
?>
