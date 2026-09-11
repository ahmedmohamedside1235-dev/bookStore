<?php

/** 
 * @var array $data 
 */
?>

<div class="content">
    <div class="row" id="Customers">
        <?=
        showUserData($data['Customers']['data']);
        ?>
    </div>
    <nav class="navigation" aria-label="Page navigation example" class="d-flex justify-content-center align-items-center mt-3">
        <ul class="pagination" data-name="Customers">
            <?= showPagination($data['Customers']['count'], $data['Customers']['currentPage'], 'Customers') ?>
        </ul>
    </nav>
</div>