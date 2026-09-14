<?php


function  prArr(array $arr, bool $die = false)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";

    if ($die) {
        exit;
    }
}
function  prArrJson(array $arr, bool $die = false)
{
    echo "<pre>";
    print_r(json_encode($arr));
    echo "</pre>";

    if ($die) {
        exit;
    }
}

function asset(string $path)
{
    return BASE_URL . "/assets/" . ltrim($path, "/");
}

function session(string $key, mixed $value = null): mixed
{
    // Getter
    if (func_num_args() === 1) {
        return $_SESSION[$key] ?? null;
    }

    // setter
    $_SESSION[$key] = $value;

    return $_SESSION[$key];
}

function isAuth(?string $role = null): bool
{
    if (!isset($_SESSION['user'])) {
        return false;
    }

    if ($role === null) {
        return true;
    }

    return ($_SESSION["user"]["role"] ?? null) === $role;
}


function auth(?string $key = null): mixed
{
    $user = $_SESSION['user'] ?? null;
    if ($key === null) {
        return $user;
    }

    return $user[$key] ?? null;
}

function isGuest(): bool
{
    return !isAuth();
}


function redirect(string $path)
{
    $url = BASE_URL . $path;
    header("location:{$url}");
    exit;
}

function route(string $path)
{
    return BASE_URL . $path;
}


function  back(?string $key = null, ?string $msg = "")
{
    $path = $_SERVER['HTTP_REFERER'];

    if ($key !== null) $_SESSION[$key] = $msg;

    header("location:{$path}");
    exit;
}

function showError(string $key)
{
    $htmlError = "";
    if (isset($_SESSION['_errors'][$key])) {
        $htmlError = "<p class='api-error-banner mb-0'><i class='fa-solid fa-circle-exclamation'></i> {$_SESSION['_errors'][$key][0]}</p>";
        unset($_SESSION['_errors'][$key]);
    }

    return $htmlError;
}

function showSessionMsg(string $key, bool $isError = true)
{
    $htmlError = "";
    $className = $isError ? 'api-error-banner' : 'alert alert-success';
    if (isset($_SESSION[$key])) {
        $htmlError = "<p class='{$className} text-center mb-3'><i class='fa-solid fa-circle-exclamation'></i> {$_SESSION[$key]}</p>";
        unset($_SESSION[$key]);
    }

    return $htmlError;
}

function old(string $key)
{
    $oldValue = $_SESSION['_old'][$key] ?? '';
    unset($_SESSION['_old'][$key]);
    return $oldValue;
}

function oldSelected(string $key, string $optionValue, bool $isLast = false, bool $isRadio = false)
{
    $isRadioChecked = $isRadio ? 'checked' : 'selected';
    $isSelected = (isset($_SESSION['_old'][$key]) && $_SESSION['_old'][$key] === $optionValue) ? $isRadioChecked : '';
    if ($isLast) unset($_SESSION['_old'][$key]);
    return $isSelected;
}

function isSelected(string $value, string $optionValue)
{
    $isSelected =  $value === $optionValue ? "selected" : '';
    return $isSelected;
}


function showDropDownLi()
{
    $registerLink = route('/auth/register');
    $loginLink = route('/auth/login');
    $logoutLink = route('/auth/logout');
    $profileLink = route('/profile');

    if (isAuth('admin')) {
        $userName = auth('name');
        return "
                <li class='nav-item dropdown mb-3 mb-lg-0'>
                    <a class='nav-link dropdown-toggle' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                        {$userName}
                    </a>
                    <ul class='dropdown-menu'>
                    <li><a class='dropdown-item Profile' href='{$profileLink}'>Profile</a></li>
                    <li><a class='dropdown-item Register' href='{$registerLink}'>Create New Admin</a></li>
                    <li><a class='dropdown-item' href='{$logoutLink}'>Logout</a></li>
                    </ul>
                </li>
                    ";
    } elseif (isAuth('customer')) {
        $userName = auth('name');
        return "
                <li class='nav-item dropdown mb-3 mb-lg-0'>
                    <a class='nav-link dropdown-toggle' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                        {$userName}
                    </a>
                    <ul class='dropdown-menu'>
                    <li><a class='dropdown-item Profile' href='{$profileLink}'>Profile</a></li>
                    <li><a class='dropdown-item' href='{$logoutLink}'>Logout</a></li>
                    </ul>
                </li>
            ";
    } else {
        return "
                <li class='nav-item dropdown mb-3 mb-lg-0'>
                    <a class='nav-link dropdown-toggle' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                        Account
                    </a>
                    <ul class='dropdown-menu'>
                        <li><a class='dropdown-item Login' href='{$loginLink}'>Login</a></li>
                        <li><a class='dropdown-item Register' href='{$registerLink}'>Register</a></li>
                    </ul>
                </li>
            ";
    }
}


function showSelectedOptions()
{
    if (isAuth('admin')) {
        $selected = oldSelected('role', 'admin', true);
        return "<option value='admin' {$selected} >Admin</option>";
    } else {
        $selected = oldSelected('role', 'customer', true);
        return "<option value='customer' {$selected}>customer</option>";
    }
}

function showUserData(array $users, bool $isAdmin = false)
{
    $registerLink = route("/auth/register");
    if (count($users) <= 0) {
        if ($isAdmin) {
            return "
                    <div class='empty d-flex flex-column justify-content-center align-items-center py-4'>
                        <div class='icon'>
                            <i class='fa-solid fa-users'></i>
                        </div>
                        <h4>No admins found</h4>
                        <p>No admins have been added yet. Start by adding the first admin to the system.</p>
                        <a class='btn btn-success' href='{$registerLink}'>
                            <i class='fa-solid fa-plus'></i>
                            Add Admin
                        </a>
                    </div>
            ";
        }

        return "<div class='empty d-flex flex-column justify-content-center align-items-center py-4'>
                    <div class='icon'>
                        <i class='fa-solid fa-user'></i>
                    </div>
                    <h4>No Customer found</h4>
                </div>";
    }

    $htmlUser = "";
    foreach ($users as $user) {
        $shortEmail = str_replace("gmail.com", "...", $user['email']);
        $image = asset($isAdmin ? "images/admin.png" : "images/customer.png");
        $isBanned = $user['is_banned'] ? '<span class="badge text-bg-danger">Banned</span>' : '';
        $isBannedBtn = "";
        if (auth('id') < $user['id']) {
            $isBannedBtn = $user['is_banned']
                ? "<button class='btn btn-secondary d-block w-100 border-0' onclick=\"toggleBanUser(this, {$user['id']}, `Unban`)\">Unban</button>"
                : "<button class='btn btn-danger d-block w-100 border-0' onclick=\"toggleBanUser(this, {$user['id']}, `Ban`)\">Ban</button>";
        }
        $htmlUser .= "
            <div class='col-md-6 col-lg-4'>
                <div data-id='{$user['id']}' class='item position-relative cardUser mb-3 py-4 px-2'>
                    {$isBanned}
                    <div class='head text-center mb-4'>
                        <img src='{$image}' class='imgUser d-block m-auto'
                            alt=''>
                        <h4 class='mt-3'>{$user['name']}</h4>
                    </div>
                    <div class='body'>
                        <div class='row'>
                            <div class='col-12'>
                                <div class='item mb-3 d-flex align-items-center flex-wrap'>
                                    <p class='me-2 mb-0 label'>Email :</p>
                                    <p class='mb-0'>{$shortEmail}</p>
                                </div>
                            </div>
                            <div class='col-12'>
                                <div class='item mb-3 d-flex align-items-center'>
                                    <p class='me-2 mb-0 label'>Gender :</p>
                                    <p class='mb-0'>{$user['gender']}</p>
                                </div>
                            </div>
                            <div class='col-12'>
                                <div class='item mb-3 d-flex align-items-center'>
                                    <p class='me-2 mb-0 label'>Phone :</p>
                                    <p class='mb-0'>{$user['phone']}</p>
                                </div>
                            </div>
                            <div class='col-12'>
                                <div class='item banBtn d-flex align-items-center'>
                                    {$isBannedBtn}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ";
    }

    return $htmlUser;
}
function showAuthors(array $authors)
{
    if (count($authors) <= 0) {
        return "
                <div class='empty d-flex flex-column justify-content-center align-items-center py-4'>
                    <div class='icon'>
                        <i class='m-auto fa-solid fa-user-group'></i>
                    </div>
                    <h4>No Authors found</h4>
                </div>
            ";
    }

    $htmlUser = "";
    foreach ($authors as $author) {
        $image = asset("images/author.png");
        $shortBio = $author['bio'] != null ? substr($author['bio'], 0, 60) : 'no bio';
        $htmlUser .= "
            <div class='col-md-6 col-lg-4'>
                <div class='item position-relative cardUser mb-3 py-4 px-2'>
                    <div class='head text-center mb-4'>
                        <img src='{$image}' class='imgUser d-block m-auto'
                            alt=''>
                        <h4 class='mt-3'>{$author['name']}</h4>
                    </div>
                    <div class='body'>
                        <div class='row'>
                            <div class='col-12'>
                                <div class='item authBio d-flex'>
                                    <p class='me-3 mb-0 label'>BIO:</p>
                                    <p class='mb-0'>{$shortBio}...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class='btn save m-auto d-block mt-4' data-bs-toggle='modal' data-bs-target='#AddBook' onclick=\"addAuthorId({$author['id']} , `{$author['name']}`)\">+ Add New Book</button>
                </div>
            </div>
        ";
    }

    return $htmlUser;
}

function showBooks(array $books)
{
    if (count($books) <= 0) {
        return "
                <div class='empty d-flex flex-column justify-content-center align-items-center py-4'>
                    <div class='icon'>
                        <i class='fa-solid fa-book'></i>
                    </div>
                    <h4>No Bools found</h4>
                </div>
            ";
    }

    $htmlBooks = "";

    foreach ($books as $book) {
        $image = $book['image'] == null ? asset("images/book.png") : asset("images/uploads/{$book['image']}");
        $shortDesc = substr($book['description'], 0, 60);
        $additionFeature = "";

        if (isAuth('customer')) {
            $additionFeature =
                "<div class='col-12'>
                <div class='item mt-3 d-flex'>
                    <div class='input-group'>
                        <input type='number' class='form-control' placeholder='Quantity' id='quntity_{$book['id']}' >
                        <button class='btn btnAddCart' type='button' id='button-addon1' onclick=\"addToCart({$book['id']} , this)\">Add To Cart</button>
                    </div>
                </div>
            </div>";
        }

        $htmlBooks .= "
            <div class='col-md-6 col-lg-4'>
                <div class='item position-relative cardUser mb-3 py-4 px-2'>
                    <div class='head text-center mb-4'>
                        <img src='{$image}' class='imgUser d-block m-auto'
                            alt=''>
                        <h6 class='mt-3'>{$book['title']}</h6>
                    </div>
                    <div class='body'>
                        <div class='row'>
                            <div class='col-12'>
                                <div class='item mb-3 d-flex align-items-center'>
                                    <p class='me-2 mb-0 label'>Authors :</p>
                                    <p class='mb-0'>{$book['author_name']}</p>
                                </div>
                            </div>
                            <div class='col-12'>
                                <div class='item d-flex mb-3 desc'>
                                    <p class='me-2 mb-0 label'>Descrip:</p>
                                    <p class='mb-0'>{$shortDesc}...</p>
                                </div>
                            </div>
                            <div class='col-12'>
                                <div class='item mb-3 d-flex align-items-center'>
                                    <p class='me-2 mb-0 label'>Price :</p>
                                    <p class='mb-0'>{$book['price']}</p>
                                </div>
                            </div>
                            <div class='col-12'>
                                <div class='item d-flex align-items-center'>
                                    <p class='me-2 mb-0 label'>Stock :</p>
                                    <p class='mb-0'>{$book['stock']}</p>
                                </div>
                            </div>
                            {$additionFeature}
                        </div>
                    </div>
                </div>
            </div>
        ";
    }

    return $htmlBooks;
}

function showPagination(int $totalPages, int $currentPage, string $paginationName)
{
    $htmlPagination = "";

    if ($totalPages <= 1) {
        return "";
    }

    $prevPage = $currentPage === 1 ? $totalPages : $currentPage - 1;
    $prevDisabledClass = $currentPage === 1 ? 'disabled' : '';

    $htmlPagination .= "
        <li class='page-item'>
            <button class='page-link {$prevDisabledClass}' onclick=\"changePage({$prevPage},'{$paginationName}')\">Previous</button>
        </li>";

    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = $currentPage === $i ? ' active' : '';
        $htmlPagination .= "
            <li class='page-item'><button class='page-link{$activeClass}' onclick=\"changePage({$i},'{$paginationName}')\">{$i}</button></li>
        ";
    }

    $nextPage = $currentPage === $totalPages ? 1 : $currentPage + 1;
    $nextDisabledClass = $currentPage === $totalPages ? 'disabled' : '';

    $htmlPagination .= "
        <li class='page-item'>
            <button class='page-link {$nextDisabledClass}' onclick=\"changePage({$nextPage},'{$paginationName}')\">Next</button>
        </li>";


    return $htmlPagination;
}

function showOrders(array $orders, bool $status, string $canceled = '')
{
    $htmlOrders = "";
    foreach ($orders as $order) {
        $isOrdered = ($status) && isAuth('admin') ?
            " <td>
                <div class='buttons d-flex justify-content-center align-items-center'>
                    <button class='btn btn-danger me-2 text-light' onclick=\"showModalCaneclReason({$order['id']})\">Cancel</button>
                    <button class='btn btn-success' data-bs-toggle='modal'
                        data-bs-target='#exampleModal' onclick=\"changeStatusOfOrder({$order['id']}, 'done')\">Done</button>
                </div>
            </td>" : '';
        $isCanceledReason = '';
        if (!empty($order['cancel_reason']) && $canceled == 'canceled') {
            $shortReason = substr($order['cancel_reason'], 0, 50);
            $isCanceledReason = "<td>{$shortReason}</td>";
        } elseif ($order['cancel_reason'] == null && $canceled == 'canceled') {
            $isCanceledReason = '<td>There are no cancel reason</td>';
        }
        $isCustomerName = isAuth('admin') ? "<td>{$order['customer_name']}</td>" : '';
        $htmlOrders .= "
            <tr data-order-id='{$order['id']}'>
                <th class='head'>{$order['id']}</th>
                {$isCustomerName}
                <td>{$order['total_price']}</td>
                <td><button class='btn save' onclick=\"getitemsIntoCart(this, 'showOrder', 'ShowOrder' , {$order['id']})\">Show</button></td>
                {$isCanceledReason}
                <td>{$order['created_at']}</td>
                {$isOrdered}
            </tr>
        ";
    }

    return $htmlOrders;
}
