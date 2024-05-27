<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h2>Создание Slider</h2>
        <form id="createSliderForm" method="POST" action="create_slider.php">
            <div class="d-flex flex-column w-25">
                <label for="slider_name">Название слайдера:</label>
                <input type="text" id="slider_name" name="slider_name" required class="form-control">
                <button type="submit" class="btn btn-primary mt-2">Создать слайдер</button>
            </div>
        </form>
    <div id="createMessageBox" class="mt-3"></div>
        
    <h2>Загрузка Файлов в Slider</h2>
        <form id="uploadImageForm" method="POST" action="upload_image.php" enctype="multipart/form-data">
            <div class="d-flex flex-column w-25">
                <label for="slider_select">Выберите слайдер:</label>
                <select id="slider_select" name="slider_select" class="form-control">
                    <?php
                    $dir = 'images/';
                    $sliders = array_filter(glob($dir . '*'), 'is_dir');
                    foreach ($sliders as $slider) {
                        $slider_name = basename($slider);
                        echo "<option value=\"$slider_name\">$slider_name</option>";
                    }
                    ?>
                </select>
                <input type="file" name="images[]" multiple required class="form-control mt-2">
                <button type="submit" class="btn btn-primary mt-2">Загрузить изображения</button>
            </div>
    </form>
        <div id="uploadMessageBox" class="mt-3"></div>
        
        <h2>Удаление Slider</h2>
        <form id="deleteSliderForm" method="POST" action="delete_slider.php">
            <div class="d-flex flex-column w-25">
                <label for="delete_slider_select">Выберите слайдер для удаления:</label>
                <select id="delete_slider_select" name="delete_slider_select" class="form-control">
                    <?php
                    foreach ($sliders as $slider) {
                        $slider_name = basename($slider);
                        echo "<option value=\"$slider_name\">$slider_name</option>";
                    }
                    ?>
                </select>
                <button type="submit" class="btn btn-danger mt-2">Удалить слайдер</button>
            </div>
        </form>
        <div id="deleteMessageBox" class="mt-3"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.getElementById('createSliderForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const formData = new FormData(this);
            fetch('create_slider.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const messageBox = document.getElementById('createMessageBox');
                messageBox.innerHTML = `<div class="alert alert-${data.type}">${data.message}</div>`;
            })
            .catch(error => {
                console.error('Ошибка:', error);
                document.getElementById('createMessageBox').innerHTML = '<div class="alert alert-danger">Произошла ошибка.</div>';
            });
        });

        document.getElementById('uploadImageForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const formData = new FormData(this);
            fetch('upload_image.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const messageBox = document.getElementById('uploadMessageBox');
                messageBox.innerHTML = `<div class="alert alert-${data.type}">${data.message}</div>`;
            })
            .catch(error => {
                console.error('Ошибка:', error);
                document.getElementById('uploadMessageBox').innerHTML = '<div class="alert alert-danger">Произошла ошибка.</div>';
            });
        });

        document.getElementById('deleteSliderForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            const formData = new FormData(this);
            fetch('delete_slider.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const messageBox = document.getElementById('deleteMessageBox');
                messageBox.innerHTML = `<div class="alert alert-${data.type}">${data.message}</div>`;
            })
            .catch(error => {
                console.error('Ошибка:', error);
                document.getElementById('deleteMessageBox').innerHTML = '<div class="alert alert-danger">Произошла ошибка.</div>';
            });
        });
    </script>
</body>

</html>
