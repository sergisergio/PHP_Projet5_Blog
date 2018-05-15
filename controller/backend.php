<?php 

/* ************************* RESUME *************************************

1 . PAGE D'ACCUEIL ADMINISTRATEUR.
2 . PAGE NO ADMIN. 
3 . PAGE DE GESTION DES ARTICLES.
4 . AJOUTER UN ARTICLE.
5 . PAGE DE MODIFICATION DES ARTICLES.
6 . MODIFIER UN ARTICLE.
7 . SUPPRIMER UN ARTICLE.
8 . PAGE DE GESTION DES COMMENTAIRES.
10. PAGE DE GESTION DES MEMBRES.
11. SUPPRIMER UN MEMBRE.
11. VALIDER UN COMMENTAIRE.
12. SUPPRIMER UN COMMENTAIRE.
13. DONNER LES DROITS ADMIN A UN MEMBRE.
14. RETIRER LES DROITS ADMIN A UN MEMBRE.

************************************************************************/

require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/UserManager.php');

/* *********** 1 . PAGE D'ACCUEIL ADMINISTRATEUR ***********************/

function indexManagement(){

	require('view/backend/index_management.php');
}

/* *********** 2 . PAGE NO ADMIN ***************************************/

function noAdmin(){

	require('view/backend/noadmin.php');
}

/* *********** 3 . PAGE DE GESTION DES ARTICLES ************************/

function managePosts(){

	$postManager = new \Philippe\Blog\Model\PostManager();
	$postsTotal = $postManager->countPosts();
	$postsPerPage = 5;
    $totalPages = ceil($postsTotal / $postsPerPage);
    if(isset($_GET['page']) AND !empty($_GET['page']) AND ($_GET['page'] > 0 ) AND ($_GET['page'] <= $totalPages)){
        $_GET['page'] = intval($_GET['page']);
        $currentPage = $_GET['page'];
    }
    else {
        $currentPage = 1;
    }
    $start = ($currentPage-1)*$postsPerPage;
	$postManager->getPosts($start, $postsPerPage);
	
	require('view/backend/Posts/post_mgmt.php');
}

/* *********** 4 . AJOUTER UN ARTICLE **********************************/

function addPost($title, $chapo, $author, $content, $image){

	$postManager = new \Philippe\Blog\Model\PostManager();
	$affectedPost = $postManager->addPostRequest($title, $chapo, $author, $content, $image);

	if ($affectedPost === false) {
        throw new Exception('Impossible d\'ajouter l\'article');
    }
    else {
        header('Location: index.php?action=manage_posts#viewposts');
    }
}

/* *********** 5 . PAGE DE MODIFICATION DES ARTICLES *******************/

function modifyPostPage($postId){

	$postManager = new \Philippe\Blog\Model\PostManager();
	$postManager->getPost($postId);
	require('view/backend/Posts/modifyPostView.php');
}

/* *********** 6 . MODIFIER UN ARTICLE *********************************/

function modifyPost($postId, $title, $chapo, $author, $content){

	$postManager = new \Philippe\Blog\Model\PostManager();
	$success = $postManager->modifyPostRequest($postId, $title, $chapo, $author, $content);
	$post = $postManager->getPost($postId);

	if ($success === false) {
		throw new Exception('Impossible de modifier l\'article');
	}
	else {
		header('Location: index.php?action=manage_posts#viewposts');
	}
}

/* *********** 7 . SUPPRIMER UN ARTICLE ********************************/

function deletePost($postId){

	$postManager = new \Philippe\Blog\Model\PostManager();
	$success = $postManager->deletePostRequest($postId);

	if ($success === false) {
		throw new Exception('Impossible de supprimer l\'article');
	}
	else {
		header('Location: index.php?action=manage_posts#viewposts');
	}
}

/* *********** 8 . PAGE DE GESTION DES COMMENTAIRES ********************/

function manageComments(){

	$commentManager = new \Philippe\Blog\Model\CommentManager();
	$commentManager->countCommentBackRequest();
	$commentManager->submittedCommentRequest();
	require('view/backend/Comments/comment_mgmt.php');
}

/* ********** 9 . PAGE DE GESTION DES MEMBRES *************************/

function manageUsers(){
	$userManager = new \Philippe\Blog\Model\UserManager();
	$userManager->getUsers();
	require('view/backend/Users/user_mgmt.php');
}

/* ********** 10 . SUPPRIMER UN MEMBRE *********************************/

function deleteUser($userId){

	$userManager = new \Philippe\Blog\Model\UserManager();
	$affectedUser = $userManager->deleteUserRequest($userId);
    if ($affectedUser === false){
        throw new Exception('Impossible de supprimer ce membre');
	}
	else {
		header('Location: index.php?action=manage_users');
	}
}

/* ********** 11 . VALIDER UN COMMENTAIRE ******************************/

function validateComment($commentId){

	$commentManager = new \Philippe\Blog\Model\CommentManager();
	$validated = $commentManager->validateCommentRequest($commentId);
	if ($validated === false) {
		throw new Exception('Impossible de valider le commentaire');
	}
	else {
		header('Location: index.php?action=manage_comments');
	}
}

/* ********** 12 . SUPPRIMER UN COMMENTAIRE ****************************/

function adminDeleteComment($commentId){

    $commentManager = new \Philippe\Blog\Model\CommentManager();
	$commentManager->getComment($commentId);
    $success = $commentManager->deleteCommentRequest($commentId);
    
    if ($success === false) {
        throw new Exception('Impossible de supprimer le commentaire');
    }
    else {
        header('Location: index.php?action=manage_comments');
    }
}
/* ********** 13 . DONNER LES DROITS ADMIN A UN MEMBRE *****************/

function giveAdminRights($userId){

	$userManager = new \Philippe\Blog\Model\UserManager();
	$adminRights = $userManager->giveAdminRightsRequest($userId);
	
	if ($adminRights === false) {
        throw new Exception('Impossible de donner les droits admin');
    }
    else {
        header('Location: index.php?action=manage_users');
    }
}
/* ********** 14 . RETIRER LES DROITS ADMIN A UN MEMBRE ****************/

function stopAdminRights($userId){

	$userManager = new \Philippe\Blog\Model\UserManager();
	$adminRights = $userManager->stopAdminRightsRequest($userId);
	
	if ($adminRights === false) {
        throw new Exception('Impossible de retirer les droits admin');
    }
    else {
        header('Location: index.php?action=manage_users');
    }
}