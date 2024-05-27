<?php
header('Content-Type: application/json');

$response = ['message' => '', 'type' => ''];

if (isset($_POST['delete_slider_select'])) {
    $slider = $_POST['delete_slider_select'];
    $dir = 'images/' . $slider;
    
    if (is_dir($dir)) {
        delete_directory($dir);
        $response['message'] = "Слайдер '$slider' удален успешно.";
        $response['type'] = 'success';
    } else {
        $response['message'] = "Слайдер не найден.";
        $response['type'] = 'danger';
    }
} else {
    $response['message'] = "Ошибка удаления слайдера.";
    $response['type'] = 'danger';
}

echo json_encode($response);

function delete_directory($dir) {
    if (!file_exists($dir)) {
        return false;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }

    return rmdir($dir);
}
?>
