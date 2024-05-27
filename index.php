<?php
require_once "./functions/helpers.php";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gallery</title>
    <link rel="stylesheet" href="https://swiperjs.com/package/css/swiper.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
</head>

<style>
    .swiper-container {
        width: 100%;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }

    .swiper-button-next {
        right: 10px;
    }

    .swiper-button-prev {
        left: 10px;
    }

    .swiper-container {
        width: 100%;
    }

    .swiper-wrapper {
        display: flex;
    }

    .swiper-slide {
        flex-shrink: 0;
        width: 100%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-img {
        width: 100%;
        max-height: 80vh;
        object-fit: contain;
    }
</style>

<body>
    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/manage">Manage Sliders</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php
        $page = $_GET['page'] ?? 'home';
        if (file_exists("./pages/$page.php")) {
            require_once "./pages/$page.php";
        } else {
            echo "Page Not Found";
        }
        ?>
    </div>

    <div class="container">
        <?php
        $dir = 'images/';
        $sliders = array_filter(glob($dir . '*'), 'is_dir');

        foreach ($sliders as $slider) {
            $slider_name = basename($slider);
            echo "<h2>$slider_name</h2>";
        ?>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php
                    $images = glob($slider . '/small/thumb_*');
                    foreach ($images as $image) {
                        $original_image = str_replace('small/thumb_', 'original/', $image);
                    ?>
                        <div class="swiper-slide">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-bs-image="<?= $original_image ?>">
                                <img src="<?= $image ?>" alt="<?= $slider_name ?>">
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        <?php } ?>
    </div>

    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" class="modal-img" src="" alt="Image">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    
    <script>
        var swipers = document.querySelectorAll('.swiper-container');

        swipers.forEach(function(swiperContainer) {
            var swiper = new Swiper(swiperContainer, {
                navigation: {
                    nextEl: swiperContainer.querySelector('.swiper-button-next'),
                    prevEl: swiperContainer.querySelector('.swiper-button-prev'),
                },
                pagination: {
                    el: swiperContainer.querySelector('.swiper-pagination'),
                },
            });
        });

        var imageModal = document.getElementById('imageModal');
        imageModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var imageSrc = button.getAttribute('data-bs-image');
            var modalImage = imageModal.querySelector('#modalImage');
            modalImage.src = imageSrc;
        });
    </script>
</body>

</html>
