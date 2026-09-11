<?php

/** 
 *@var array $total
 */

?>

<div class="content">
    <div class="row row-cols-lg-4">
        <div class="col">
            <div class="item state py-3 mb-3 d-flex align-items-center flex-column ">
                <i class="m-auto fa-solid fa-book"></i>
                <h6 class="my-3">Total Books</h6>
                <p class="text-success Books fw-bolder mb-0"><?= $total['totalBooks'] ?></p>
            </div>
        </div>
        <?php if (isAuth('admin')) {
            echo "<div class='col'>
                                <div class='item state py-3 mb-3 d-flex align-items-center flex-column '>
                                    <i class='m-auto fa-solid fa-user-group'></i>
                                    <h6 class='my-3'>Total Authors</h6>
                                    <p class='text-success Authors fw-bolder mb-0'>{$total['totalAuthors']}</p>
                                </div>
                            </div>
                            <div class='col'>
                                <div class='item state py-3 mb-3 d-flex align-items-center flex-column '>
                                    <i class='m-auto fa-solid fa-users'></i>
                                    <h6 class='my-3'>Total Customers</h6>
                                    <p class='text-success fw-bolder mb-0'>{$total['totalCustomers']}</p>
                                </div>
                            </div>
                            <div class='col'>
                                <div class='item state py-3 mb-3 d-flex align-items-center flex-column '>
                                    <i class='m-auto fa-solid fa-users-gear'></i>
                                    <h6 class='my-3'>Total Admins</h6>
                                    <p class='text-success fw-bolder mb-0'>{$total['totalAdmins']}</p>
                                </div>
                            </div>
                        ";
        }
        if (isAuth('customer')) {
            echo "<div class='col'>
                        <div class='item state py-3 mb-3 d-flex align-items-center flex-column '>
                            <i class='m-auto fa-solid fa-user-group'></i>
                            <h6 class='my-3' id='BoughtBooks'>Total Bought Books</h6>
                            <p class='text-success totalBoughtBooks fw-bolder mb-0'>{$total['totalBoughtBooks']}</p>
                        </div>
                    </div>
                ";
        } ?>
        <div class="col">
            <div class="item state py-3 mb-3 d-flex align-items-center flex-column ">
                <i class="m-auto fa-solid fa-circle-pause"></i>
                <h6 class="my-3">Total Ordered Orders</h6>
                <p class="text-success Ordered fw-bolder mb-0"><?= $total['orders']['ordered'] ?></p>
            </div>
        </div>
        <div class="col">
            <div class="item state py-3 mb-3 d-flex align-items-center flex-column ">
                <i class="m-auto fa-solid fa-ban"></i>
                <h6 class="my-3">Total Canceled Orders</h6>
                <p class="text-success fw-bolder mb-0"><?= $total['orders']['canceled'] ?></p>
            </div>
        </div>
        <div class="col">
            <div class="item state py-3 mb-3 d-flex align-items-center flex-column ">
                <i class="m-auto fa-solid fa-circle-check"></i>
                <h6 class="my-3">Total Done Orders</h6>
                <p class="text-success fw-bolder mb-0"><?= $total['orders']['done'] ?></p>
            </div>
        </div>
    </div>
</div>