<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | <?= ucfirst(auth('role')) ?></title>
    <link rel="stylesheet" href="<?= asset('shared/styles/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('shared/styles/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= asset('shared/styles/global/global.css') ?>">
    <link rel="stylesheet" href="<?= asset('profile/css/profile.css') ?>">
</head>

<body class="text-light">
    <?php require_once __DIR__ . "/../shared/components/navbar.php" ?>

    <div class="container-fluid py-5">
        <div class="content">
            <div class="row">
                <div class="col-xl-3 part part1">
                    <div class="item cardUser py-4 px-3 mb-3">
                        <div class="head text-center py-4 px-3">
                            <img src="<?= asset('images/admin.png') ?>" class="imgUser d-block m-auto" alt="">
                            <h2 class="mt-3 mb-0">
                                <i onclick='showModel("name")' class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                    data-bs-target="#EditModal"></i>
                                <span id="Name"><?= auth('name') ?></span>
                            </h2>
                        </div>
                        <div class="body mt-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="item mb-3 d-flex align-items-center">
                                        <p class="me-2 mb-0 icon"><i onclick='showModel("email")' class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                                data-bs-target="#EditModal"></i> Email : </p>
                                        <p class="mb-0"><span id="Email"><?= auth('email') ?></span></p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="item mb-3 d-flex align-items-center">
                                        <p class="me-2 mb-0 icon"><i onclick='showModel("gender",true)' class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                                data-bs-target="#EditModal"></i> Gender : </p>
                                        <p class="mb-0"><span id="Gender"><?= auth('gender') ?></span></p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="item mb-3 d-flex align-items-center">
                                        <p class="me-2 mb-0 icon"><i onclick='showModel("phone")' class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                                data-bs-target="#EditModal"></i> Phone : </p>
                                        <p class="mb-0"><span id="Phone"><?= auth('phone') ?></span></p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="item d-flex align-items-center">
                                        <p class="me-2 mb-0 icon"><i onclick='showModel("password" ,false ,"password")' class="fa-solid fa-pen-to-square" data-bs-toggle="modal"
                                                data-bs-target="#EditModal"></i> Password </p>
                                        <p class="mb-0"><span id="Password"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9 part part2">
                    <div class="item py-4 px-3">
                        <!--* navbar model -->
                        <div class="nav-links position-relative">
                            <?php if (isAuth('admin')) {
                                require_once __DIR__ . "/components/admin_links.php";
                            } elseif (isAuth('customer')) {
                                require_once __DIR__ . "/components/customer_links.php";
                            } ?>
                        </div>

                        <!--* Content Navs-->
                        <?php if (isAuth('admin')) {
                            require_once __DIR__ . "/components/admin_content.php";
                        } elseif (isAuth('customer')) {
                            require_once __DIR__ . "/components/customer_content.php";
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once __DIR__ . "/components/modals.php" ?>

    <script src="<?= asset('shared/script/bootstrap.js') ?>"></script>
    <script src="<?= asset('shared/script/jquery.js') ?>"></script>
    <script src="<?= asset('shared/script/sweetalert.js') ?>"></script>
    <script src="<?= asset('shared/script/activeNavLinks.js') ?>"></script>
    <script>
        const authId = <?= auth('id') ?>;
        const authRole = "<?= auth('role') ?>";
    </script>
    <script src="<?= asset('profile/js/functions.js') ?>"></script>
    <script src="<?= asset('profile/js/profile.js') ?>"></script>

</body>

</html>