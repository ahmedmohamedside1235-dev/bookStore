<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="<?= asset("images/logo.png") ?>" class="img-fluid" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="middle"></span>
            <span class="middle my-2"></span>
            <span class="middle"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item mb-3 me-0  me-lg-2 mb-lg-0">
                    <a class="nav-link active" aria-current="page" href="<?= route("") ?>">Home</a>
                </li>
                <?= showDropDownLi() ?>
            </ul>
        </div>
    </div>
</nav>