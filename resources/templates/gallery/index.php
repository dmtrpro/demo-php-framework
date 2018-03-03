<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">Это пример галереи</h1>
        <p class="lead text-muted">Вы также можете загрузить в неё своё изображение</p>
        <p>
            <button class="btn btn-primary my-2" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                Добавить изображение
            </button>
        </p>
    </div>
</section>

<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            <?php foreach ($page['imageCards'] as $card) {
                include TEMPLATE_DIR . '/gallery/_card.php';
            } ?>
        </div>
    </div>
</div>