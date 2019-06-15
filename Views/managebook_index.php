<link rel="stylesheet" href="/css/managebook-index.css">

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

<?PHP foreach ($books as $book) { ?>
    <div class="row book-edit-row">
        <div class="col-md-3">
            <strong><?= $book->getName() ?></strong>
        </div>
        <div class="col-md-4">
            authors
        </div>
        <div class="col-md-3">
            badges
        </div>
        <div class="col-md-1">
            <a href="/managebook/edit?id=<?= $book->getId() ?>">Edit</a>
        </div>
        <div class="col-md-1">
            <button>Remove</button><!-- Сделать обработку через jQuery -->
        </div>
    </div>
<?PHP } ?>
