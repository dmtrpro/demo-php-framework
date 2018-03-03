<div class="col-md-4">
    <div class="card mb-4 box-shadow">
        <?php if($card['image']): ?>
            <img class="card-img-top"
             alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;"
             src="uploads/<?= $card['image']; ?>"
             data-holder-rendered="true">
        <?php endif; ?>
        <div class="card-body">
            <?php if($card['excerpt']): ?>
                <p class="card-text"><?= $card['excerpt']; ?></p>
            <?php endif; ?>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="<?= $card['slug'] ?>" class="btn btn-sm btn-outline-secondary">View</a>
                    <!--a href="<?= $card['slug'] ?>" class="btn btn-sm btn-outline-secondary">Edit</a-->
                </div>
                <small class="text-muted">9 mins</small>
            </div>
        </div>
    </div>
</div>