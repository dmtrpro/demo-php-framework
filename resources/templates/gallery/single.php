

<div class="album py-5 bg-light">
    <div class="container">
        <a href="/" class="btn btn-secondary mb-2">Back</a>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-12 box-shadow">
                    <?php if($page['image']): ?>
                        <img class="card-img-top"
                             alt="Thumbnail [100%x225]" style="height: 100%; width: 100%; display: block;"
                             src="uploads/<?= $page['image']; ?>"
                             data-holder-rendered="true">
                    <?php endif; ?>
                    <div class="card-body">
                        <?php if($page['excerpt']): ?>
                            <p class="card-text"><?= $page['excerpt']; ?></p>
                        <?php endif; ?>
                        <div class="d-flex justify-content-between align-items-center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>