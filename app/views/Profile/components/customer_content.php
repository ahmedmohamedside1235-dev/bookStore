<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active statistics" id="statistics-pane" role="tabpanel" aria-labelledby="statistics" tabindex="0">
        <?php require_once __DIR__ . "/statistics.cards.php"; ?>
    </div>
    <div class="tab-pane fade" id="books-pane" role="tabpanel" aria-labelledby="books"
        tabindex="0">
        <div id="BookFilter">
            <form class="p-3 p-lg-5  mb-4" id="BookFilterForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="item">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="Title"><i class="fa-solid fa-book"></i></label>
                                <input type="text" id="Title" class="form-control" placeholder="Title..." name="title">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="item">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="Author"><i class="fa-solid fa-user"></i></label>
                                <input type="text" id="Author" class="form-control" placeholder="Author..." name="author">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="item">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="MinPrice"><i class="fa-solid fa-dollar-sign"></i></label>
                                <input type="number" id="MinPrice" class="form-control" placeholder="Min Price..." name="minPrice">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="item">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="MaxPrice"><i class="fa-solid fa-dollar-sign"></i></label>
                                <input type="number" id="MaxPrice" class="form-control" placeholder="Max Price..." name="maxPrice">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="item">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="Stock"><i class="fa-solid fa-hashtag"></i></label>
                                <input type="number" id="Stock" class="form-control" placeholder="Stock..." name="stock">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="item">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="Sort"><i class="fa-solid fa-arrow-up-short-wide"></i></label>
                                <select name="sort" id="Sort" class="form-control">
                                    <option value='DESC' selected>⬆ DESC</option>
                                    <option value='ASC'>⬇ ASC</option>
                                </select>
                                <?= showError('role') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn save w-100 d-block">Filter</button>
            </form>
        </div>
        <?php require_once __DIR__ . "/books.cards.php"; ?>
    </div>
    <div class="tab-pane fade" id="orders_ordered-pane" role="tabpanel" aria-labelledby="orders_ordered"
        tabindex="0">
        <?php require_once __DIR__ . "/orders_ordered.php"; ?>
    </div>
    <div class="tab-pane fade" id="orders_canceled-pane" role="tabpanel" aria-labelledby="orders_canceled"
        tabindex="0">
        <?php require_once __DIR__ . "/orders_canceled.php"; ?>
    </div>
    <div class="tab-pane fade" id="orders_done-pane" role="tabpanel" aria-labelledby="orders_done"
        tabindex="0">
        <?php require_once __DIR__ . "/orders_done.php"; ?>
    </div>
</div>