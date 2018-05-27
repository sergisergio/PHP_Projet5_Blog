<?php
/* ************************* RESUME *************************************
1 . 
2 . 

************************** FIN RESUME **********************************/
namespace Philippe\Blog\Model;
require_once "model/Manager.php";
class SessionManager extends Manager
{
    /* ************ 1 . RECUPERER TOUS LES ARTICLES *******************/
    public function stopSession()
    {
        unset($_SESSION);
        session_destroy();
        header('Location: index.php?action=blog');
    }

    public function errorPseudo1()
    {
        $_SESSION['flash']['danger'] = 'Ce pseudo est déjà pris !';
        signupPage();
        exit();
    }

    public function errorPseudo2()
    {
        $_SESSION['flash']['danger'] = 'Votre pseudo n\'est pas valide (caractères alphanumériques et underscore permis... !';
        signupPage();
        exit();
    }

    public function errorEmail1()
    {
        $_SESSION['flash']['danger'] = 'Cet email est déjà utilisé !';
        signupPage();
        exit();
    }

    public function errorEmail2()
    {
        $_SESSION['flash']['danger'] = 'Votre email n\'est pas valide !';
        signupPage();
        exit();
    }

    public function errorPassword()
    {
        $_SESSION['flash']['danger'] = 'Vous devez entrer un mot de passe valide !';
        signupPage();
        exit();
    }

    public function emptyContents()
    {
        $_SESSION['flash']['danger'] = 'Vous devez remplir tous les champs !';
        signupPage();
        exit();
    }

    public function badRequest()
    {
        $_SESSION['flash']['danger'] = 'Inscription impossible !';
        signupPage();
        exit();
    }

    public function registerSuccess()
    {
        $_SESSION['flash']['success'] = 'Un mail de confirmation vous a été envoyé pour valider votre compte';
        loginPage();
        exit();
    }

    public function activateAccount()
    {
        $_SESSION['flash']['danger'] = 'Vous devez activer votre compte via le lien de confirmation dans le mail envoyé !';
        loginPage();
        exit();
    }

    public function errorPassword2()
    {
        $_SESSION['flash']['danger'] = 'Mauvais identifiant ou mot de passe !';
        loginPage();
        exit();
    }

    public function emptyContents2()
    {
        $_SESSION['flash']['danger'] = 'Vous devez remplir tous les champs !';
        loginPage();
        exit();
    }

    public function registerSuccess2()
    {
        $_SESSION['flash']['success'] = 'Votre inscription a bien été prise en compte ! Vous pouvez vous connecter !';
        loginPage();
        exit();
    }

    public function errorToken()
    {
        $_SESSION['flash']['success'] = 'Ce token n est plus valide ! Veuillez réessayer ! !';
        signupPage();
        exit();
    }

    public function registerFailure()
    {
        $_SESSION['flash']['danger'] = 'Echec de l\'inscription ! Veuillez réessayer sinon contactez l\'administrateur';
        signupPage();
        exit();
    }

    public function noIdPost()
    {
        $_SESSION['flash']['danger'] = 'Aucun id ne correspond à ce billet !';
        errors();
        exit();
    }

    public function addedComment()
    {
        $_SESSION['flash']['success'] = 'Votre commentaire sera validé dans les plus brefs délais !';
        
    }

    public function needsRegister()
    {
        $_SESSION['flash']['success'] = 'Vous devez être inscrit pour ajouter un commentaire !';
    }

    public function emptyContent()
    {
        $_SESSION['flash']['danger'] = 'Le champ est vide !';
    }

    public function noIdComment()
    {
        $_SESSION['flash']['danger'] = 'Cet identifiant ne correspond à aucun commentaire !';
        errors();
        exit();
    }

    public function noRightsComments()
    {
        $_SESSION['flash']['danger'] = 'Vous pouvez seulement modifier vos propres commentaires !';
        errors();
        exit();
    }
}