<?php

/** 
 * @var array $data 
 */
?>


<div class="content">
    <div class="row" id="Authors">
        <?= showAuthors($data['Authors']['data']) ?>
    </div>
    <?php if (!empty($data['Authors']['data'])) {
        echo "<button class='btn-add-author w-100 d-block my-3' data-bs-toggle='modal'
                data-bs-target='#AddAuthor'>Add new author</button>";
    } ?>
    <nav class="navigation" aria-label="Page navigation example" class="d-flex justify-content-center align-items-center mt-3">
        <ul class="pagination" data-name="Authors">
            <?= showPagination($data['Authors']['count'], $data['Authors']['currentPage'], 'Authors') ?>
        </ul>
    </nav>
</div>