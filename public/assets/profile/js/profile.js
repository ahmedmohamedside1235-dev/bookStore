let currentPages = {
    Admins: 1,
    Customers: 1,
    Authors: 1,
    Books: 1,
    BooksFilter: 1,
    Orders_ordered: 1,
    Orders_canceled: 1,
    Orders_done: 1,
},
    sectionData = {
        Admins: showDataOfUsers,
        Customers: showDataOfUsers,
        Authors: showAuthors,
        Books: showBooks,
        Orders_ordered: showOrders,
        Orders_canceled: showOrders,
        Orders_done: showOrders,
    },
    lastRequestData = null;

$('#FormEdit').submit(function (e) {
    e.preventDefault();
    let modalEl = document.querySelector("#EditModal"),
        modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl),
        inputEl = document.querySelector("#EditModal .modal-body form input") ?? document.querySelector("#EditModal .modal-body form select"),
        inputName = inputEl?.name ?? 'gender',
        para = document.querySelector(`#${inputName.charAt(0).toUpperCase() + inputName.slice(1)}`),
        originalValue = para?.textContent.trim(),
        currentDisplayValue = "";

    if (inputEl) {
        if (inputEl.tagName === 'SELECT') {
            currentDisplayValue = inputEl.options[inputEl.selectedIndex]?.text.trim();
        } else {
            inputEl.value = inputEl.value.trim();
            currentDisplayValue = inputEl.value;
        }
    }

    if (currentDisplayValue.toLowerCase() === originalValue.toLowerCase()) {
        modalInstance.hide();
        return;
    }

    let formData = new FormData(this);
    formData.append("inputName", inputName);

    $.ajax({
        url: "profile/editUser",
        type: "POST",
        data: formData,
        success: function (response) {
            showAlert('success', response.message);
            modalInstance.hide();
            para.textContent = (inputName == "password" ? '' : response.data[`${inputName}`]);
        },
        error: function (error) {
            console.log(error);
            showAlert('error', error.responseJSON.message);
        },
    })
});

$('#AddAuthorForm').submit(function (e) {
    e.preventDefault();
    let modalEl = document.querySelector("#AddAuthor"),
        modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl),
        formData = new FormData(this),
        paginationActive = document.querySelector('.pagination[data-name="Authors"] li button.active');
    formData.append("page", paginationActive ? paginationActive.textContent : 1);
    $.ajax({
        url: "profile/addAuthor",
        type: "POST",
        data: formData,
        success: function (response) {
            let pageNumber = parseInt(response.data.currentPage);
            $('#AddAuthorForm').get(0).reset();
            modalInstance.hide();
            showAlert('success', response.message);
            $(`#AddAuthorForm p.api-error-banner`).addClass('d-none');
            getDataRow('Authors', 1);
            $('p.text-success.Authors').text(
                Number($('p.text-success.Authors').text()) + 1
            );
        },
        error: function (response) {
            let errors = response.responseJSON.data;
            showErrorAdd(errors);
        },
    })
});

$('#BookFilterForm').submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    getBooksFilter(formData);
});

$("#AddBookForm").submit(function (e) {
    e.preventDefault();
    let modalEl = document.querySelector("#AddBook"),
        modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl),
        formData = new FormData(this);
    formData.append("authorId", $('#AddBookForm #AuthorBookId option').val())
    $.ajax({
        url: "profile/addBook",
        type: "POST",
        data: formData,
        success: function (response) {
            $('#AddBookForm').get(0).reset();
            modalInstance.hide();
            showAlert('success', response.message);
            $(`#AddBookForm p.api-error-banner`).addClass('d-none');
            getDataRow('Books', 1);
            $('p.text-success.Books').text(
                Number($('p.text-success.Books').text()) + 1
            );
        },

        error: function (response) {
            console.log(response);
            let errors = response.responseJSON.data;
            showErrorAdd(errors);
        }
    })
})

$('.modal').on('hide.bs.modal', function () {
    $(`p.api-error-banner`).addClass('d-none');
});


