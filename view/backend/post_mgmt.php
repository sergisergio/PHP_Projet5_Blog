<?php $title = 'Gestion des articles'; ?>
<?php ob_start(); ?>

    <body class="full-layout">
        <!--<div id="preloader"><div id="status"><div class="loadcircle"></div></div></div>-->
        <div class="body-wrapper">
            <?php include "view/frontend/includes/nav.php"; ?>
                <!-- /#home -->
                <div class="container">
                    
                                <?php include "includes/management.php"; ?>

                                <h2 class="text-center">Gestion des articles</h2>
                <?php
                    while ($data = $posts->fetch())
                    {
                    ?>
                        <div class="post box">
            <div class="row">
                    <h2 class="post-title"><a href="blog-post.php"><?php echo htmlspecialchars($data['title']); ?></a></h2>
                    <btn class="btn btn-default" style="float: right;"><a href="index.php?action=deletePost">Supprimer</a></btn>
                    <btn class="btn btn-default" style="float: right;"><a href="index.php?action=modifyPost">Modifier</a></btn>


            </div>
        </div>
                     <?php
                } // Fin de la boucle des billets
                $posts->closeCursor();
                ?>
                                                   
                </div>
                <!-- /.container -->
        </div>
        <!-- /.body-wrapper -->
        <?php include "view/frontend/includes/foot.php"; ?>
    </body>

    <?php $content = ob_get_clean(); ?>

    <?php require('template.php'); ?>