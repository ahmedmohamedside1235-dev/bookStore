<?php
require_once __DIR__ . "/../../helpers/helpers.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="<?= asset('shared/styles/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= asset('shared/styles/global/global.css') ?>">
    <link rel="stylesheet" href="<?= asset('home/css/index.css') ?>">
</head>

<body>
    <?php require_once __DIR__ . "/../shared/components/navbar.php" ?>

    <header class="d-flex justify-content-center align-items-center">
        <div class="container">
            <div id="carouselExampleCaptions" class="carousel slide " data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row align-items-center h-100">
                            <div class="col-lg-6">
                                <div class="item text-light">
                                    <h5>SEARCH BOOKS EASILY</h5>
                                    <h2>ISBN Search Feature</h2>
                                    <p>Search books using ISBN numbers or Auther names and save your time</p>
                                </div>
                            </div>
                            <div class="col-lg-6 h-100">
                                <div class="item image">
                                    <img src="<?= asset("images/slide_1.png") ?>" class="img-fluid" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row align-items-center h-100">
                            <div class="col-lg-6">
                                <div class="item text-light">
                                    <h5>LARGEST CATALOG</h5>
                                    <h2>Over 12 Million Books</h2>
                                    <p>Start your learning journey by browsing Millions of books from our library </p>
                                </div>
                            </div>
                            <div class="col-lg-6 h-100">
                                <div class="item image">
                                    <img src="<?= asset("images/slide_2.png") ?>" class="img-fluid" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row align-items-center h-100">
                            <div class="col-lg-6">
                                <div class="item text-light">
                                    <h5>SEARCH BOOKS EASILY</h5>
                                    <h2>ISBN Search Feature</h2>
                                    <p>Search books using ISBN numbers or Auther names and save your time</p>
                                </div>
                            </div>
                            <div class="col-lg-6 h-100">
                                <div class="item image">
                                    <img src="<?= asset("images/slide_3.png") ?>" class="img-fluid" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>

    <script src="<?= asset('shared/script/bootstrap.js') ?>"></script>
    <script src="<?= asset('shared/script/jquery.js') ?>"></script>
    <script src="<?= asset('home/js/index.js') ?>"></script>
    <script src="<?= asset('shared/script/activeNavLinks.js') ?>"></script>

</body>

</html>