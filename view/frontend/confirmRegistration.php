<?php $title = 'Confirmation'; ?>
<?php ob_start(); ?>

<body class="full-layout">
    <div class="body-wrapper">
        <?php include "includes/nav.php"; ?>
            <!-- /#home -->
        <div class="container">
            <div class="divide30"></div>
            <div class="col-md-offset-2 col-md-6 col-sm-12"></div>
        </div>
            <!-- /.container -->
    </div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>