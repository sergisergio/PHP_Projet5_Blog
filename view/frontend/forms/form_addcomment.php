<div class="form-container">
            <div class="response alert"></div>
            <?php if(isset($_SESSION['flash'])): ?>
                <?php foreach($_SESSION['flash'] as $type => $message): ?>
                    <div class="alert alert-<?= $type; ?>">
                        <?= $message; ?>
                    </div>
                <?php endforeach; ?>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>
<form action="index.php?action=addcomment&amp;id=<?= $post['id'] ?>" method="post">
    <div>
        <label for="content">Commentaire</label>
        <br />
        <textarea id="content" name="content"></textarea>
    </div>
    <p class="text-center">Votre commentaire sera publié dans les plus brefs délais après modération</p>
    <div>
        <input class="btn btn-default" type="submit" style="width: 100px;display: block; margin: 0 auto;"/>
    </div>
</form>
</div>