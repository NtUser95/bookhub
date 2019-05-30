<form class="needs-validation" method="post" novalidate="">
    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Обложка</span>
            </h4>
            <div class="col-md">
                <input type="file" name="cover_image">
            </div>
        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Добавить книгу</h4>
            <div class="mb-3">
                <label for="bookName">Название книги</label>
                <input type="text" name="name" class="form-control" id="bookName" placeholder="" value="" required="">
                <div class="invalid-feedback">
                    Valid first name is required.
                </div>
            </div>

            <div class="mb-3">
                <div class="form-group">
                    <label for="descriptionInput">Описание</label>
                    <textarea name="description" class="form-control" id="descriptionInput" rows="3"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="authorsTextarea">Автор</label>
                        <textarea name="authors" class="form-control" id="authorsTextarea" rows="3"></textarea>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="genresTextarea">Жанры</label>
                        <textarea name="genres" class="form-control" id="genresTextarea" rows="3"></textarea>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="published-date">Дата публикации</label>
                        <input type="date" class="form-control" id="published-date" name="published_date">
                    </div>
                </div>
            </div>

            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Добавить</button>
        </div>
    </div>
</form>