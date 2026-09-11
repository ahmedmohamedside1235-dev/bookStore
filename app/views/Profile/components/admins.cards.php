<?php

/** 
 * @var array $data 
 */
?>

<div class="content">
    <div class="row" id="Admins">
        <?=
        showUserData($data['Admins']['data'], true);
        ?>
    </div>
    <nav class="navigation" aria-label="Page navigation example" class="d-flex justify-content-center align-items-center mt-3">
        <ul class="pagination" data-name="Admins">
            <?= showPagination($data['Admins']['count'], $data['Admins']['currentPage'], 'Admins') ?>
        </ul>
    </nav>
</div>