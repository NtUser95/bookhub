<link rel="stylesheet" href="/css/books-index.css">

<div class="dropdown filter-dropdown">
    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Все жанры
    </a>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <a class="dropdown-item" href="#">Action</a>
        <a class="dropdown-item" href="#">Another action</a>
        <a class="dropdown-item" href="#">Something else here</a>
    </div>
</div>

<div class="dropdown filter-dropdown">
    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Все авторы
    </a>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <a class="dropdown-item" href="#">Action</a>
        <a class="dropdown-item" href="#">Another action</a>
        <a class="dropdown-item" href="#">Something else here</a>
    </div>
</div>

<div class="dropdown filter-dropdown">
    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        За всё время
    </a>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <a class="dropdown-item" href="#">Action</a>
        <a class="dropdown-item" href="#">Another action</a>
        <a class="dropdown-item" href="#">Something else here</a>
    </div>
</div>

<div class="dropdown filter-dropdown">
    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Сортировать
    </a>

    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <a class="dropdown-item" href="#">По названию</a>
        <a class="dropdown-item" href="#">По дате публикации</a>
    </div>
</div>

<div class="row">
    <?PHP foreach ($books as $book) { ?>
        <div class="col-md-3 book-block">
            <div class="row book-title">
                <h4>
                    <strong><?= $book->getName() ?></strong>
                </h4>
            </div>
            <div class="row book-description">
                <?= $book->getDescription() ?>
            </div>
            <div class="row book-image">
                <?PHP $logoUrl = $book->getImageEntity() ? $book->getImageEntity()->getExternalPath() : '/images/book_preview.png'; ?>
                <img src="<?= $logoUrl ?>" class="book-image" title="book preview">
            </div>
            <div class="row book-badges">
                badges
            </div>
        </div>
    <?PHP } ?>
</div>
