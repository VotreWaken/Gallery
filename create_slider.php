<?php
header('Content-Type: application/json');

$response = ['message' => '', 'type' => ''];

if (isset($_POST['slider_name'])) {
    $slider_name = $_POST['slider_name'];
    $dir = 'images/' . $slider_name;

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
        mkdir($dir . '/original', 0777, true);
        mkdir($dir . '/small', 0777, true);
        $response['message'] = "Слайдер '$slider_name' создан успешно.";
        $response['type'] = 'success';
    } else {
        $response['message'] = "Слайдер с таким названием уже существует.";
        $response['type'] = 'danger';
    }
}

echo json_encode($response);
?>
