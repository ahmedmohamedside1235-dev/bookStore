<ul class="nav nav-tabs mb-4 d-flex justify-content-center align-items-center" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link me-3 active" id="statistics" data-bs-toggle="tab"
            data-bs-target="#statistics-pane" type="button" role="tab" aria-controls="statistics-pane"
            aria-selected="true">Statistics</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link me-3" id="admins" data-bs-toggle="tab" data-bs-target="#admins-pane"
            type="button" role="tab" aria-controls="admins-pane"
            aria-selected="false">Admins</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link me-3" id="customers" data-bs-toggle="tab" data-bs-target="#customers-pane"
            type="button" role="tab" aria-controls="customers-pane"
            aria-selected="false">Customers</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link me-3" id="authors" data-bs-toggle="tab" data-bs-target="#authors-pane"
            type="button" role="tab" aria-controls="authors-pane"
            aria-selected="false">Authors</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link me-3" id="books" data-bs-toggle="tab" data-bs-target="#books-pane"
            type="button" role="tab" aria-controls="books-pane"
            aria-selected="false">Books</button>
    </li>
    <li class="nav-item" role="presentation">
        <div class="dropdown">
            <button class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Orders
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item mb-2" id="orders_ordered" data-bs-toggle="tab" data-bs-target="#orders_ordered-pane"
                        type="button" role="tab" aria-controls="orders_ordered-pane"
                        aria-selected="false">Ordered</a></li>
                <li><a class="dropdown-item mb-2" id="orders_canceled" data-bs-toggle="tab" data-bs-target="#orders_canceled-pane"
                        type="button" role="tab" aria-controls="orders_canceled-pane"
                        aria-selected="false">Cancel</a></li>
                <li><a class="dropdown-item" id="orders_done" data-bs-toggle="tab" data-bs-target="#orders_done-pane"
                        type="button" role="tab" aria-controls="orders_done-pane"
                        aria-selected="false">Done</a></li>
            </ul>
        </div>
    </li>
</ul>