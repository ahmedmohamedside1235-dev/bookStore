    <?php

    /** 
     * @var array $data 
     */
    ?>


    <!--  Edit Modal -->
    <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Edit Name</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="FormEdit">
                        <div class="mb-4 inputs">
                            <label for="Edit" class="form-label">Email :</label>
                            <input type="text" class="form-control" name="email" id="Edit">
                        </div>
                        <div class="buttons d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
                            <button class="btn save text-light" type="submit">Save change</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--  Add Author Modal -->
    <div class="modal fade" id="AddAuthor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Add new author</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="AddAuthorForm">
                        <div class="mb-4">
                            <label for="AuthorName" class="form-label">Name :</label>
                            <input type="text" class="form-control" name="name" id="AuthorName">
                            <p class="api-error-banner d-none" data-name="name"></p>
                        </div>
                        <div class="mb-4">
                            <label for="AuthorBio" class="form-label">Bio :</label>
                            <textarea class="form-control" name="bio" rows="10" id="AuthorBio"></textarea>
                            <p class="api-error-banner d-none" data-name="bio"></p>
                        </div>

                        <div class="buttons d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
                            <button class="btn save text-light" type="submit">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--  Add Book Modal -->
    <div class="modal fade" id="AddBook" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">Add New Book</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="AddBookForm">
                        <div class="mb-4">
                            <label for="AuthorBookId" class="form-label">Author :</label>
                            <select class="form-control" name="authorId" id="AuthorBookId" disabled>
                                <option value="" selected hidden></option>
                            </select>
                            <p class="api-error-banner d-none" data-name="authorId"></p>
                        </div>

                        <div class="mb-4">
                            <label for="BookTitle" class="form-label">Title :</label>
                            <input type="text" class="form-control" name="title" id="BookTitle">
                            <p class="api-error-banner d-none" data-name="title"></p>
                        </div>

                        <div class="mb-4">
                            <label for="BookImage" class="form-label">Image :</label>
                            <input type="file" class="form-control" name="image" id="BookImage">
                            <p class="api-error-banner d-none" data-name="image"></p>
                        </div>

                        <div class="mb-4">
                            <label for="BookDescription" class="form-label">Descrition :</label>
                            <textarea class="form-control" name="description" id="BookDescription" rows="10"></textarea>
                            <p class="api-error-banner d-none" data-name="description"></p>
                        </div>

                        <div class="mb-4">
                            <label for="BookPrice" class="form-label">Price :</label>
                            <input type="number" class="form-control" name="price" id="BookPrice">
                            <p class="api-error-banner d-none" data-name="price"></p>
                        </div>

                        <div class="mb-4">
                            <label for="BookStock" class="form-label">Stock :</label>
                            <input type="number" class="form-control" name="stock" id="BookStock">
                            <p class="api-error-banner d-none" data-name="stock"></p>
                        </div>

                        <div class="buttons d-flex justify-content-center align-items-center">
                            <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
                            <button class="btn save text-light" type="submit">Add</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--  Cart Modal -->
    <div class="modal fade" id="Cart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Cart</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <!--  showOrders Modal -->
    <div class="modal fade" id="ShowOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title"><?php if (isAuth('admin')) {
                                                echo "Customer Order";
                                            } else {
                                                echo "Your Order";
                                            } ?></h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    <!--  showOrders Modal -->
    <div class="modal fade" id="CanceledReason" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Cancel Reason</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="TextArea" class="form-label">Cancel Reason</label>
                        <textarea class="form-control" id="TextArea" rows="8"></textarea>
                    </div>
                    <button class="btn btn-danger w-100" onclick="cancelOrder()">Cancel Order</button>
                </div>
            </div>
        </div>
    </div>