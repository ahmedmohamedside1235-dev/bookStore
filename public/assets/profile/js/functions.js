function showPagination(totalPages, currentPage, paginationName, isFilter = false) {
    let htmlPagination = "";

    if (totalPages <= 1) {
        $(`.pagination[data-name='${paginationName}']`).html("");
        return;
    }

    let prevPage = currentPage === 1 ? totalPages : currentPage - 1;

    htmlPagination += `
        <li class="page-item">
            <button class="page-link ${currentPage === 1 ? 'disabled' : ''}" onclick="changePage(${prevPage}, '${paginationName}' , ${isFilter})">Previous</button>
        </li>`;

    for (let i = 1; i <= totalPages; i++) {
        htmlPagination += `
            <li class="page-item"><button class="page-link ${currentPage === i ? 'active' : ''}" onclick="changePage(${i}, '${paginationName}' , ${isFilter})">${i}</button></li>
        `;
    }

    let nextPage = currentPage === totalPages ? 1 : currentPage + 1;

    htmlPagination += `
        <li class="page-item">
            <button class="page-link ${currentPage === totalPages ? 'disabled' : ''}" onclick="changePage(${nextPage}, '${paginationName}' ,${isFilter} )">Next</button>
        </li>`;

    $(`.pagination[data-name='${paginationName}']`).html(htmlPagination);
}

function showDataOfUsers(users, dataName) {
    $(`#${dataName}`).html("");
    let isAdmin = dataName == 'Admins' ? true : false;
    if (users.length <= 0) {
        $(`.pagination[data-name='${dataName}']`).html("");
        if (isAdmin) {
            $(`#${dataName}`).html(`
                    <div class="empty d-flex flex-column justify-content-center align-items-center py-4">
                        <div class="icon">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h2>No admins found</h2>
                        <p>No admins have been added yet. Start by adding the first admin to the system.</p>
                        <a class="btn btn-success" href="${getPathLinkPage('auth/register')}">
                            <i class="fa-solid fa-plus"></i>
                            Add Admin
                        </a>
                    </div>
            `)
            return;
        }
        $(`#${dataName}`).html(`
            <div class="empty d-flex flex-column justify-content-center align-items-center py-4">
                <div class="icon">
                    <i class="fa-solid fa-user"></i>
                </div>
                <h4>No Customer found</h4>
            </div>
        `)
        return;
    }

    let htmlTr = "";
    users.forEach(user => {
        let isBanned = user['is_banned'] ? '<span class="badge text-bg-danger">Banned</span>' : '',
            isBannedBtn = "";
        if (authId <= user.id) {
            isBannedBtn = user['is_banned'] ?
                `<button class="btn btn-secondary d-block w-100 border-0" onclick="toggleBanUser(this,${user.id} , 'Unban')">Unban</button>`
                :
                `<button class="btn btn-danger d-block w-100 border-0" onclick="toggleBanUser(this,${user.id} , 'Ban')">Ban</button>`;
        }
        htmlTr += `
            <div class="col-md-6 col-lg-4">
                <div data-id="${user['id']}" class="item position-relative cardUser mb-3 py-4 px-2">
                    ${isBanned}
                    <div class="head text-center mb-4">
                        <img src="${isAdmin ? imagePath('admin.png') : imagePath('customer.png')}" class="imgUser d-block m-auto"
                            alt="">
                        <h4 class="mt-3">${user['name']}</h4>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-12">
                                <div class="item mb-3 d-flex align-items-center flex-wrap">
                                    <p class="me-2 mb-0 label">Email :</p>
                                    <p class="mb-0">${user['email'].replace(/@.+/, '@...')}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="item mb-3 d-flex align-items-center">
                                    <p class="me-2 mb-0 label">Gender :</p>
                                    <p class="mb-0">${user['gender']}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="item mb-3 d-flex align-items-center">
                                    <p class="me-2 mb-0 label">Phone :</p>
                                    <p class="mb-0">${user['phone']}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="item banBtn d-flex align-items-center">
                                    ${isBannedBtn}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `
    });

    $(`#${dataName}`).html(htmlTr);
    return;
}

function showAuthors(authors, dataName) {
    $(`#${dataName}`).html("");
    if (authors.length <= 0) {
        $(`.pagination[data-name='${dataName}']`).html("");
        $(`#${dataName}`).html(`
            <div class='empty d-flex flex-column justify-content-center align-items-center py-4' >
                <div class='icon'>
                    <i class='m-auto fa-solid fa-user-group'></i>
                </div>
                <h4>No Authors found</h4>
            </div>
        `);
        $('.btn-add-author').remove();
        return;
    }

    let htmlAuthors = "";
    authors.forEach((author) => {
        htmlAuthors += createAuthorHtml(author);
    });
    $(`#${dataName}`).html(htmlAuthors);
    return;
}

function showOrders(orders, dataName) {
    let orderType = dataName.replace('Orders_', '');
    $(`#${dataName} tbody`).html("");
    if (orders.length <= 0) {
        $(`.pagination[data-name='${dataName}']`).html("");
        $(`#${dataName} tbody`).html(`
            <tr>
                <td colspan=" ${authRole == 'admin' ? 6 : 5}">
                    <div class="empty d-flex flex-column justify-content-center align-items-center py-4">
                        <div class="icon">
                            <i class="fa-solid fa-arrow-up-wide-short"></i>
                        </div>
                        <h4>There are no ${orderType} orders</h4>
                    </div>
                </td>
            </tr>
        `);
        return;
    }

    $(`#${dataName} tbody`).html(``);
    orders.forEach((order) => {
        appendDataIntoTable(dataName, order);
    });

    return;
}

function showBooks(books, dataName) {
    $(`#${dataName}`).html("");
    if (books.length <= 0) {
        $(`.pagination[data-name='${dataName}']`).html("");
        $(`#${dataName}`).html(`
            <div class='empty d-flex flex-column justify-content-center align-items-center py-4' >
                <div class='icon'>
                    <i class="fa-solid fa-book"></i>
                </div>
                <h4>No Books found</h4>
            </div>
        `);
        return;
    }
    let htmlBooks = "";
    books.forEach((book) => {
        if (authRole == "customer") {
            htmlBooks += bookComponent(book, "main", authRole);
        } else {
            htmlBooks += bookComponent(book);
        }
    });
    $(`#${dataName}`).html(htmlBooks);
    return;
}

function changePage(pageNumber, sectionName, isFilter = false) {
    let key = isFilter ? `${sectionName}Filter` : sectionName;
    if (pageNumber === currentPages[key]) {
        return;
    }
    currentPages[key] = pageNumber;

    if (isFilter)
        getFilterPaginationBooks(pageNumber);
    else {
        (authRole == 'customer' && sectionName != 'Books') ? getDataRow(sectionName, null, true) : getDataRow(sectionName);
    }
}

// pagination data 
function getDataRow(paginationName, page = null, except = false) {
    $.ajax({
        url: `profile/getData`,
        type: "POST",
        data: {
            "typeData": paginationName,
            "pageNumber": page ?? currentPages[paginationName],
            "except": except
        },
        success: function (response) {
            let data = response.data;
            sectionData[paginationName](data[paginationName]['data'], paginationName);
            showPagination(data[paginationName]['count'], data[paginationName]['currentPage'], paginationName);
            currentPages[paginationName] = data[paginationName]['currentPage'];
        },

        error: function (error) {
            console.log(error);
            showAlert('error', error.responseJSON.message)
        }
    });
}

function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1)
}

function subStr(str) {
    if (str == null)
        return;

    if (str.length <= 50)
        return str;

    return str.slice(0, 50) + '...';
}

function showModel(inputName, isSelected = false, type = "text") {
    let model = document.querySelector("#EditModal"),
        ModelTitle = model.querySelector("#EditModal .modal-title"),
        content = document.querySelector("#EditModal .modal-body .inputs"),
        textEl = document.querySelector(`#${capitalize(inputName)}`),
        inputValue = "";
    ModelTitle.textContent = `Edit ${inputName}`;
    inputValue = textEl.textContent.trim();
    if (isSelected) {
        content.innerHTML = `
            <label for="Gender" class="form-label">Gender :</label>
            <select name="gender" i , thisd="Gender" class="form-control">
                <option value="" ${inputValue === '' ? 'selected' : ''}  hidden></option>
                <option value='male' ${inputValue === 'male' ? 'selected' : ''} >Male</option>"
                <option value='female' ${inputValue === 'female' ? 'selected' : ''} >Female</option>"
            </select>
        `
        return;
    }

    content.innerHTML = `
            <label for="Edit" class="form-label">${capitalize(inputName) + " : "}</label>
            <input type="${type}" value="${inputName === "password" ? "" : inputValue}" class="form-control" name =         "${inputName}" id = "Edit">
        `;
}

function showAlert(status, msg) {
    Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    }).fire({
        icon: status,
        title: msg
    });
}

function imagePath(imageName, isUpload) {
    return window.location.origin + `/assets/images${isUpload ? '/uploads/' : '/'}${imageName}`;
}

function showErrorAdd(errors) {
    for (let error in errors) {
        $(`p.api-error-banner[data-name=${error}]`).text(errors[error][0]).removeClass('d-none');
    }
}

function createAuthorHtml(author) {
    let shortBio = author['bio']?.slice(0, 60) ?? 'no bio';
    return `
            <div class='col-md-6 col-lg-4' >
                <div class='item position-relative cardUser mb-3 py-4 px-2'>
                    <div class='head text-center mb-4'>
                        <img src='${imagePath('author.png')}' class='imgUser d-block m-auto'
                            alt=''>
                            <h4 class='mt-3'>${author['name']}</h4>
                    </div>
                    <div class='body'>
                        <div class='row'>
                            <div class='col-12'>
                                <div class='item authBio d-flex'>
                                    <p class='me-3 mb-0 label'>BIO:</p>
                                    <p class='mb-0'>${shortBio}...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class='btn save m-auto d-block mt-4' data-bs-toggle='modal' data-bs-target='#AddBook' onclick="addAuthorId(${author['id']}, '${author['name']}')">+ Add New Book</button>
                </div>
            </div>
            `
}

function getFilterPaginationBooks(pageNumber) {
    let formData = new FormData($('#BookFilterForm').get(0));
    formData.append('pageNumber', pageNumber);
    getBooksFilter(formData);
}

function getBooksFilter(formData) {
    console.log(serializeFormData(formData));
    let currentRequestData = serializeFormData(formData);

    if (currentRequestData === lastRequestData) {
        return;
    }

    let previousRequestData = lastRequestData;
    lastRequestData = currentRequestData;

    $.ajax({
        url: "profile/filterBooks",
        type: "POST",
        data: formData,
        success: function (response) {
            let books = response.data.data;
            showBooks(books, "Books");
            showPagination(response.data.count, response.data.currentPage, "Books", true);
            currentPages.BooksFilter = response.data.currentPage;
        },
        error: function (response) {
            lastRequestData = previousRequestData;
            showAlert('error', 'faild search books please try again later');
        },
    });
}

// convert form data to string 
function serializeFormData(formData) {
    let entries = [];
    for (let pair of formData.entries()) {
        entries.push(pair[0] + '=' + pair[1]);
    }
    return entries.sort().join('&');
}


function addAuthorId(authorId, authorName) {
    $('#AddBookForm #AuthorBookId option').val(authorId).text(authorName);
}

function toggleBanUser(btn, userId, text) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: `Yes, ${text} it!`
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "profile/toggleBanUser",
                type: "POST",
                data: { user_id: userId },
                success: function (response) {
                    console.log(response);
                    let isBanned = response.data[0],
                        parentBtn = btn.parentElement;
                    showAlert('success', response.message);
                    if (isBanned == 1) {
                        $(`.item.cardUser[data-id="${userId}"]`).prepend(`<span class="badge text-bg-danger">Banned</span>`);
                    } else {
                        $(`.item.cardUser[data-id="${userId}"] .badge.text-bg-danger`).remove();
                    }
                    btn.textContent = text == 'Unban' ? 'Ban' : 'Unban';
                    parentBtn.innerHTML = isBanned == 1
                        ? `<button class="btn btn-secondary d-block w-100 border-0" onclick="toggleBanUser(this,${userId} , 'Unban')">Unban</button>`
                        : `<button class="btn btn-danger d-block w-100 border-0" onclick="toggleBanUser(this,${userId} , 'ban')">Ban</button>`
                },

                error: function (response) {
                    if (response.responseJSON?.data) {
                        showAlert('error', response.responseJSON.data);
                    } else {
                        showAlert('error', response.responseJSON.message);
                    }
                }
            });
        }
    });
}

function getPathLinkPage(linkName) {
    console.log(window.location.origin + linkName);
    return window.location.origin + linkName;
}

function addToCart(bookId, btn) {
    let input = $(btn).prev(),
        inputValue = input.val();
    $(btn).prop('disabled', true);

    if (inputValue === '' || inputValue == 0) {
        showAlert('error', 'Please enter quantity number greater than 0');
        $(btn).prop('disabled', false);
        return;
    }

    let data = {
        quantity: inputValue,
        book_id: bookId
    }

    $.ajax({
        url: "profile/orderBook",
        type: "POST",
        data: data,
        success: function (response) {
            input.val("");
            $("#NumberOfOrders").text(response.data.totalItmesOrders);
            showAlert('success', response.message);
            $(btn).prop('disabled', false);
        },
        error: function (response) {
            $(btn).prop('disabled', false);
            if (response.responseJSON?.data) {
                showAlert('error', response.responseJSON.data.quantity[0]);
            } else {
                showAlert('error', response.responseJSON.message);
            }
        }
    })
}

function getitemsIntoCart(btn, status = 'cart', modalName = 'Cart', orderId = null) {
    $(btn).prop('disabled', true);

    let formData = { orderId: orderId };

    if (orderId == null) {
        formData = "";
    }

    $.ajax({
        url: "profile/getitemsIntoCart",
        type: "POST",
        data: formData,
        success: function (response) {
            console.log(response);
            let books = response.data;
            $(btn).prop('disabled', false);
            if (books.length == 0) {
                $(`#${modalName} .modal-body`).html(`
                    <p class="alert alert-warning text-center w-100"> Your cart is empty. Add some books to your cart first.</p>
                `);
            } else {
                $(`#${modalName} .modal-body`).html(`
                    <h3 class='text-center mb-4'>Total Order Price : <span class='total' id="TotalPrice">${books[0].total_price}</span></h3>
                    <div class="row"></div>
                    ${status == 'cart' ? `<button onclick="orderNow(${books[0].order_id} ,this)" class="btn save w-100">Order Now</button>` : ''}
                `);
                books.forEach(book => {
                    $(`#${modalName} .modal-body > .row`).append(bookComponent(book, status, 'customer'));
                });
            }

            toggleModal(`${modalName}`, 'open');

        },
        error: function (response) {
            $(btn).prop('disabled', false);
            if (response.responseJSON?.data) {
                showAlert('error', Object.values(response.responseJSON.data)[0][0]);
            } else {
                showAlert('error', response.responseJSON.message);
            }
        }
    })
}

function bookComponent(book, status = "main", authRole = 'admin') {
    let shortDesc = book['description'].slice(0, 60),
        addition = {
            main:
                `<div class='col-12'>
                    <div class='item d-flex align-items-center'>
                        <p class='me-2 mb-0 label'>Stock :</p>
                        <p class='mb-0'>${book['stock']}</p>
                    </div>
                </div>`
                + (authRole === 'customer' ?
                    `<div class='col-12'>
                            <div class='item mt-3 d-flex'>
                                <div class='input-group'>
                                    <input type='number' min='1' class='form-control' placeholder='Quantity'  id='quntity_${book['id']}'>
                                    <button class='btn btnAddCart' type='button' id='button-addon1' onclick="addToCart(${book['id']} , this)">Add To Cart</button>
                                </div>
                            </div>
                        </div>`
                    : ``),

            cart: `<div class='col-12'>
                        <div class='item mb-3 d-flex align-items-center'>
                            <p class='me-2 mb-0 label'>Subtotal :</p>
                            <p class='mb-0 subtotal-${book['orders_items_id']}'>${book['subtotal']}</p>
                        </div>
                    </div>
                    <div class="input-group w-75 m-auto">
                        <button onclick="changeQuantity(${book['orders_items_id']} , 'decrease', this)" class="btn btn-outline-danger"><i class="fa-solid fa-minus"></i></button>
                        <input type="text" disabled class="form-control text-center quatity-${book['orders_items_id']}" value='${book['quantity']}'>
                        <button onclick="changeQuantity(${book['orders_items_id']} , 'increase', this)" class="btn btn-plus"><i class="fa-solid fa-plus"></i></button>
                    </div>`,

            showOrder: `<div class='col-12'>
                            <div class='item d-flex align-items-center'>
                                <p class='me-2 mb-0 label'>Subtotal :</p>
                                <p class='mb-0 subtotal-${book['orders_items_id']}'>${book['subtotal']}</p>
                            </div>
                        </div>`
                +
                `<div class='col-12'>
                    <div class='item mt-3 d-flex align-items-center'>
                        <p class='me-2 mb-0 label'>Quantity :</p>
                        <p class='mb-0 quantity-${book['quantity']}'>${book['quantity']}</p>
                    </div>
                </div>`
        }

    return `
        <div class='col-md-6 col-lg-4 itemCard'>
            <div class='item position-relative cardUser mb-3 py-4 px-2'>
                ${status == 'cart' ? `<i class="fa-solid fa-trash-can" id='DeleteItem' onclick="deleteOrderItem(${book['orders_items_id']} , this)"></i>` : ''}
                <div class='head text-center mb-4'>
                    <img src='${book['image'] == null ? imagePath('book.png') : imagePath(book['image'], true)}' class='imgUser d-block m-auto'
                        alt=''>
                    <h6 class='mt-3'>${book['title']}</h6>
                </div>
                <div class='body'>
                    <div class='row'>
                        <div class='col-12'>
                            <div class='item mb-3 d-flex align-items-center'>
                                <p class='me-2 mb-0 label'>Authors :</p>
                                <p class='mb-0'>${book['author_name']}</p>
                            </div>
                        </div>
                        <div class='col-12'>
                            <div class='item d-flex mb-3 desc'>
                                <p class='me-2 mb-0 label'>Descrip:</p>
                                <p class='mb-0'>${shortDesc}...</p>
                            </div>
                        </div>
                        <div class='col-12'>
                            <div class='item mb-3 d-flex align-items-center'>
                                <p class='me-2 mb-0 label'>Price :</p>
                                <p class='mb-0'>${book['price']}</p>
                            </div>
                        </div>
                        ${addition[status]}
                    </div>
                </div>
            </div>
        </div>
        `;
}

function toggleModal(modalId, status = 'hide') {
    let modalEl = document.querySelector(`#${modalId}`),
        modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
    if (status == 'hide') {
        modalInstance.hide();
        return;
    }
    modalInstance.show();
}

function changeQuantity(orderItemId, type, btn) {
    if (type != 'increase' && type != 'decrease') {
        showAlert('error', 'This action is forbidden. Unauthorized modification detected.');
        return;
    }

    $('#Cart .modal-body button').prop('disabled', true).addClass('hideButton');

    let data = {
        orderItemId: orderItemId,
        typeAction: type
    }

    $.ajax({
        url: "profile/changeQuantity",
        type: "POST",
        data: data,
        success: (response) => {
            $('#Cart .modal-body button').prop('disabled', false).removeClass('hideButton');
            let data = response.data,
                orderItem = data.orderItem;

            if (orderItem.quantity == 0) {
                btn.closest('.itemCard').remove();
                $('#NumberOfOrders').text(data.totalOrderIntoCart);

                if (data.totalOrderIntoCart == 0) {
                    $('#Cart .modal-body').html(`
                        <p class="alert alert-warning text-center w-100"> Your cart is empty. Add some books to your cart first.</p>
                    `);
                    return;
                }

            } else {
                $(`.subtotal-${orderItem['id']}`).text(orderItem['subtotal']);
                $(`input.quatity-${orderItem['id']}`).val(orderItem['quantity']);
            }

            $('#TotalPrice').text(data.totalPrice);
        },
        error: (response) => {
            $('#Cart .modal-body button').prop('disabled', false).removeClass('hideButton');
            if (response.responseJSON?.data) {
                showAlert('error', Object.values(response.responseJSON.data)[0][0]);
            } else {
                showAlert('error', response.responseJSON.message);
            }
        },
    })
}

function deleteOrderItem(orderItemId, btn) {
    let data = {
        orderItemId: orderItemId
    }

    $(btn).prop('disabled', true).addClass('hideButton');

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: `Yes, delete it!`
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "profile/deleteOrderItem",
                type: "POST",
                data: data,
                success: (response) => {
                    let data = response.data;
                    $(btn).prop('disabled', false).removeClass('hideButton');
                    btn.closest('.itemCard').remove();
                    showAlert('success', "The book has been deleted successfully.");
                    if (data.totalOrderIntoCart == 0) {
                        $('#Cart .modal-body').html(`
                    <p class="alert alert-warning text-center w-100"> Your cart is empty. Add some books to your cart first.</p>
                `);
                    } else {
                        $('#TotalPrice').text(data.totalPrice);
                    }

                    $('#NumberOfOrders').text(data.totalOrderIntoCart);
                },
                error: (response) => {
                    $('#Cart .modal-body button').prop('disabled', false).removeClass('hideButton');
                    if (response.responseJSON?.data) {
                        showAlert('error', Object.values(response.responseJSON.data)[0][0]);
                    } else {
                        showAlert('error', response.responseJSON.message);
                    }
                },
            })
        }
    });
}


function orderNow(orderId, btn) {
    let data = {
        orderId: orderId
    }

    $(btn).prop('disabled', true).addClass('hideButton');

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: `Yes, Order it!`
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "profile/orderNow",
                type: "POST",
                data: data,
                success: (response) => {
                    console.log(response);
                    let orders = response.data.orders;
                    $(btn).prop('disabled', false).removeClass('hideButton');
                    showAlert('success', "The Order has been Ordered successfully.");
                    $('#Cart .modal-body').html(``);
                    $('#NumberOfOrders').text(0);
                    toggleModal('Cart', 'hide');
                    showOrders(orders.data, 'Orders_ordered');
                    showPagination(orders.count, orders.currentPage, 'Orders_ordered');
                    $('.Ordered').text(Number($('.Ordered').text()) + 1);
                    $(`.totalBoughtBooks`).text(response.data.boughtBooks);
                },
                error: (response) => {
                    $('#Cart .modal-body button').prop('disabled', false).removeClass('hideButton');
                    if (response.responseJSON?.data) {
                        showAlert('error', Object.values(response.responseJSON.data)[0][0]);
                    } else {
                        showAlert('error', response.responseJSON.message);
                    }
                },
            })
        } else {
            $(btn).prop('disabled', false).removeClass('hideButton');
        }
    });
}

// append order into table (done , ordered , canceled)
function appendDataIntoTable(sectionName, order, status = 'append') {
    let isOrdered = (sectionName == "Orders_ordered"),
        tbody = $(`#${sectionName} tbody`);

    if (tbody.length == 1 && !tbody.find('tr:first').attr('data-order-id')) {
        tbody.empty();
    }

    let rowData = `
            <tr data-order-id='${order.id}'>
                <th class='head'>${order['id']}</th>
                ${(authRole == "admin") ? `<td>${order['customer_name']}</td>` : ''}
                <td>${order['total_price']}</td>
                <td><button class='btn save' onclick="getitemsIntoCart(this, 'showOrder', 'ShowOrder' , ${order.id})">Show</button></td>
                ${sectionName == 'Orders_canceled' ? `<td>${subStr(order['cancel_reason']) ?? 'There are no cancel reason'}</td>` : ''}
                <td>${order['created_at']}</td>
                ${isOrdered && authRole == 'admin' ?
            `<td>
                    <div class="buttons d-flex justify-content-center align-items-center">
                        <button class="btn btn-danger me-2 text-light" onclick="showModalCaneclReason(${order.id})">Cancel</button>
                        <button class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#exampleModal" onclick="changeStatusOfOrder(${order.id}, 'done')">Done</button>
                    </div>
                </td>` : ''}
            </tr>`

    if (status == 'append') {
        tbody.append(rowData);
        return;
    }

    tbody.prepend(rowData);
}


function changeStatusOfOrder(orderId, status, cancelReson = null) {
    if (status != "done" && status != "canceled") {
        showAlert('error', 'This action is forbidden. Unauthorized modification detected.');
        return;
    }

    $(`tr[data-order-id='${orderId}'] button`).prop('disabled', true).addClass('hideButton');

    let formData = {
        orderId: orderId,
        status: status
    }

    if (cancelReson != null) {
        formData['cancelReson'] = cancelReson;
    }

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: `Yes, ${status} it!`
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "profile/changeStatusOfOrder",
                type: "POST",
                data: formData,
                success: (response) => {
                    console.log(response);
                    $(`tr[data-order-id='${orderId}'] button`).prop('disabled', false).removeClass('hideButton');
                    showAlert('success', `The Order has been ${status} successfully.`)
                    getDataRow('Orders_ordered', 1, true);
                    getDataRow(`Orders_${status}`, 1, true);
                    toggleModal('CanceledReason');
                    $('#CanceledReason textarea').val("");
                },
                error: (response) => {
                    $(`tr[data-order-id='${orderId}'] button`).prop('disabled', false).removeClass('hideButton');
                    if (response.responseJSON?.data) {
                        showAlert('error', Object.values(response.responseJSON.data)[0][0]);
                    } else {
                        showAlert('error', response.responseJSON.message);
                    }
                },
            })
        } else {
            $(`tr[data-order-id='${orderId}'] button`).prop('disabled', false).removeClass('hideButton');
        }
    });
}

function showModalCaneclReason(orderId) {
    toggleModal('CanceledReason', 'open');
    $(`#CanceledReason`).attr('data-orderid', orderId);
}

function cancelOrder() {
    let cancelReasonText = $('#CanceledReason textarea').val().trim(),
        orderId = $(`#CanceledReason`).attr('data-orderid');

    if (cancelReasonText.length == 0) {
        showAlert('error', 'Cancel reason is required');
        return;
    }

    changeStatusOfOrder(orderId, 'canceled', cancelReasonText);
}