<?php if(isset($_SESSION['flash'])) : ?>
    <?php foreach($_SESSION['flash'] as $type => $message): ?>
         <div class="alert alert-<?php echo $type; ?>" style="text-align:center;">
            <?php echo $message; ?>
         </div>
    <?php endforeach; ?>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>