<?php

/** 
 * @var array $data 
 */
?>

<div class="content">
    <div class="row" id="Books">
        <?= showBooks($data['Books']['data']) ?>
    </div>
    <nav class="navigation" aria-label="Page navigation example" class="d-flex justify-content-center align-items-center mt-3">
        <ul class="pagination" data-name="Books">
            <?= showPagination($data['Books']['count'], $data['Books']['currentPage'], 'Books') ?>
        </ul>
    </nav>
</div>