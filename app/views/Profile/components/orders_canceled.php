<?php

/** 
 * @var array $data 
 */
?>

<div class="content" id="Orders_canceled">
    <div class="table-responsive table-striped mb-4">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <?= isAuth('admin') ? "<th>Customer</th>" : ''; ?>
                    <th>Total Price</th>
                    <th>Details</th>
                    <th>Cancel Reason</th>
                    <th>created_at</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['Orders_canceled']['data'])): ?>
                    <?= showOrders($data['Orders_canceled']['data'], false, 'canceled') ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= isAuth('admin') ? 6 : 5 ?>">
                            <div class="empty d-flex flex-column justify-content-center align-items-center py-4">
                                <div class="icon">
                                    <i class="fa-solid fa-arrow-up-wide-short"></i>
                                </div>
                                <h4>There are no canceled orders</h4>
                            </div>
                        </td>
                    </tr>

                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <nav class="navigation" aria-label="Page navigation example" class="d-flex justify-content-center align-items-center mt-3">
        <ul class="pagination" data-name="Orders_canceled">
            <?= showPagination($data['Orders_canceled']['count'], $data['Orders_canceled']['currentPage'], 'Orders_canceled') ?>
        </ul>
    </nav>
</div>