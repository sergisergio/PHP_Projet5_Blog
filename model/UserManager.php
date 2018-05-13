<?php

/* ************************* RESUME *************************************

1 . RECUPERER TOUS LES MEMBRES.
2 . RECUPERER UN SEUL MEMBRE.
3 . RECUPERER AUTORISATION DU MEMBRE.
4 . MODIFIER UN MEMBRE.
5 . SUPPRIMER UN MEMBRE.
6 . INSCRIPTION.
7 . CONFIRMATION INSCRIPTION.
8 . LE PSEUDO EST-IL DEJA PRIS ?
9 . L'EMAIL EST-IL DEJA PRIS ?
10. CONNEXION.
11. DECONNEXION.
12. CHECK RESET TOKEN.
13. CHANGE PASSWORD.
14. MAIL RESET PASSWORD.
15. COOKIE.
16. SUPPRIMER MON COMPTE.
17. DONNER DROITS ADMIN.
18. RETIRER DROITS ADMIN.

*********************** FIN RESUME *************************************/

namespace Philippe\Blog\Model;

require_once("model/Manager.php");

class UserManager extends Manager
{
/* ************** 1 . RECUPERER TOUS LES MEMBRES ***********************/
	public function getUsers()
	{
		
		$db = $this->dbConnect();

		$req = $db->query('SELECT * 
			FROM Users 
			ORDER BY pseudo');
		return $req;
	}

/* ************** 2 . RECUPERER UN SEUL MEMBRE *************************/
	public function getUser($userId){

		$db = $this->dbConnect();

		$req = $db->prepare('SELECT id, first_name, last_name, pseudo, password, email, DATE_FORMAT(registration_date, \'%d/%m/%Y à %Hh%imin\') AS registration_date_fr, authorization, avatar, description, is_active
			FROM Users 
			WHERE id = ?');

		$req->execute(array($userId));
		$post = $req->fetch();
		return $post;
	}

/* ************** 3 . RECUPERER AUTORISATION DU MEMBRE *****************/

	public function getAuthorization($pseudo){

		$db = $this->dbConnect();

		$req = $db->prepare('SELECT id, first_name, last_name, pseudo, password, email, confirmation_token, DATE_FORMAT(registration_date, \'%d/%m/%Y à %Hh%imin\') AS registration_date_fr, authorization, avatar, description, is_active
			FROM Users 
			WHERE pseudo = ?
			');

		$req->execute(array($pseudo));
		
		$access = $req->fetch();
		return $access;
	}

/* ************** 4 . MODIFIER UN MEMBRE *******************************/
	public function modifyUserRequest($userId){

		$db = $this->dbConnect();

		$post = $db->prepare('UPDATE Users SET title = ?, intro = ?, author = ?, content = ?, creation_date = NOW() WHERE id = ?');

		$affectedPost = $post->execute(array($title, $intro, $author, $content, $postId));
		
		return $affectedPost;
	}
	
/* ************** 5 . SUPPRIMER UN MEMBRE ******************************/
	public function deleteUserRequest($userId){
        $db = $this->dbConnect();

		$post = $db->prepare('DELETE FROM Users WHERE id = ?');

		$affectedUser = $post->execute(array($userId));
		
		return $affectedUser;
    }

/* ************** 6 . INSCRIPTION **************************************/
	public function addUserRequest($pseudo, $email, $passe){

		$db = $this->dbConnect();
		
		$post = $db->prepare('INSERT INTO Users(pseudo, email, password, confirmation_token) VALUES(?, ?, ?, ?)');

		$passe = password_hash($_POST['passe'], PASSWORD_BCRYPT);

		function str_random($length){
		   	$alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
		    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length); 
		}

		    $token = str_random(100);

		$users = $post->execute(array($pseudo, $email, $passe, $token));
        
        $user_id = $db->lastInsertId();
        
        /* test mail local */
		//mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte, merci de cliquer sur ce lien\n\nhttp://localhost:8888/Blog_Project5/index.php?action=confirmRegistration&id=$user_id&token=$token");
        
        /* test mail serveur */
        $mail = 'ptraon@gmail.com';
        $to = $_POST['email'];
        $subject = 'Confirmation de votre compte';
        $body = "Afin de valider votre compte, merci de cliquer sur ce lien :\n\nhttp://www.projet5.philippetraon.com/index.php?action=confirmRegistration&id=$user_id&token=$token";
        $headers = "From: $mail \n";
        $headers .= 'X-Mailer: PHP/' . phpversion();
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=iso-8859-1\n";
        mail($to, $subject , $body, $headers);
        // $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
        return $users;
	}
    
/* ************** 7 . CONFIRMATION INSCRIPTION *************************/

	public function setActiveRequest($userId) {
		$db = $this->dbConnect();

		$req = $db->prepare('UPDATE Users SET is_active = 1, confirmation_token = NULL, registration_date = NOW() WHERE id = ?');

		$activeUser = $req->execute(array($userId));

		return $activeUser;
	}

/* ************** 8 . LE PSEUDO EST-IL DEJA PRIS ? *********************/

    public function existPseudo($pseudo) {

    	$db = $this->dbConnect();

    	$req = $db->prepare('SELECT id FROM Users WHERE pseudo = ?');

    	$req->execute([$_POST['pseudo']]);

    	$user = $req->fetch();

    	return $user;
    }

/* ************** 9 . L'EMAIL EST-IL DEJA PRIS ? ***********************/
	public function existMail($email) {

    	$db = $this->dbConnect();

    	$req = $db->prepare('SELECT id FROM Users WHERE email = ?');

    	$req->execute([$_POST['email']]);

    	$usermail = $req->fetch();

    	return $usermail;
    }

/* ************** 10. CONNEXION ****************************************/
	public function loginRequest($pseudo, $passe){

		$db = $this->dbConnect();

		$req = $db->prepare('SELECT * FROM Users WHERE pseudo = :pseudo');

        $req->execute(array('pseudo' => $pseudo));

		$user = $req->fetch();
        
        return $user;
    }

/* ************** 11. DECONNEXION **************************************/

    public function logoutRequest(){

		session_destroy();
		unset($_SESSION['pseudo']);
		unset($_SESSION['id']);
        unset($_SESSION['prenom']);
        unset($_SESSION['nom']);
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        unset($_SESSION['autorisation']);
        unset($_SESSION['avatar']);
        unset($_SESSION['registration']);
        unset($_SESSION['description']);
        unset($_SESSION['color']);
		header('Location: index.php?action=blog');

    }

/* ************** 12. CHECK RESET TOKEN ********************************/

    public function checkResetTokenRequest($userId){

    	$db = $this->dbConnect();

    	$req = $db->prepare('SELECT * FROM Users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
    	$req->execute([$_GET['id'], $_GET['token']]);
    	$user = $req->fetch();
    	return $user;
	}

/* ************** 13. CHANGE PASSWORD **********************************/

    public function changePasswordRequest($userId, $passe) {
		$db = $this->dbConnect();
		
		$passe = password_hash($_POST['passe'], PASSWORD_BCRYPT);
		$req = $db->prepare('UPDATE Users SET password = ?, reset_token = NULL, reset_at = NULL WHERE id = ?');
		
		$changePassword = $req->execute(array($passe, $userId));

		return $changePassword;
	}
    
/* ************** 14. MAIL RESET PASSWORD ******************************/

    public function forgetPasswordRequest($email) {
        
        $db = $this->dbConnect();
        
        $req = $db->prepare('SELECT * FROM Users where email = ? AND registration_date IS NOT NULL');
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        if($user) {

        	function str_random($length){
		   	$alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
		    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length); 
			}

		    $reset_token = str_random(100);
		    $user_id = $user['id'];
		    $db->prepare('UPDATE Users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user_id]);

		    /* test mail serveur */
        $mail = 'ptraon@gmail.com';
        $to = $_POST['email'];
        $subject = 'Changement de votre mot de passe';
        $body = "Afin de changer votre mot de passe, merci de cliquer sur ce lien :\n\nhttp://www.projet5.philippetraon.com/index.php?action=changePasswordPage&id=$user_id&token=$reset_token";
        $headers = "From: $mail \n";
        $headers .= 'X-Mailer: PHP/' . phpversion();
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=iso-8859-1\n";
        mail($to, $subject , $body, $headers);
        }
        else {
        	echo 'Aucun compte ne correspond à cette adresse';
        } 
        return $user;
    }

/* ************** 15. COOKIE *******************************************/

    public function rememberRequest($userId, $rememberToken) {
        
        $db = $this->dbConnect();
        function str_random($length){
		   	$alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
		    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length); 
		}
        $rememberToken = str_random(100);
        $req = $db->prepare('UPDATE Users SET remember_token = ? WHERE id = ?');
        $req->execute([$rememberToken, $userId]);
        return $req;
        setcookie('remember', $userId . '==' . $rememberToken . sha1($userId . 'cookieTraon'), time() + 60 * 60 * 24 * 7);
    }

/* ************** 16. SUPPRIMER MON COMPTE *****************************/
	public function deleteAccountRequest($userId){
        $db = $this->dbConnect();

		$post = $db->prepare('DELETE FROM Users WHERE id = ?');

		$deleteAccount = $post->execute(array($userId));
		
		return $deleteAccount;
    }

/* ************** 17. DONNER DROITS ADMIN ******************************/

	public function giveAdminRightsRequest($userId) {
		$db = $this->dbConnect();

		$req = $db->prepare('UPDATE Users SET authorization = 1 WHERE id = ?');

		$adminRights = $req->execute(array($userId));

		return $adminRights;
	}

/* ************** 18. RETIRER DROITS ADMIN *****************************/

	public function stopAdminRightsRequest($userId) {
		$db = $this->dbConnect();

		$req = $db->prepare('UPDATE Users SET authorization = 0 WHERE id = ?');

		$adminRights = $req->execute(array($userId));

		return $adminRights;
	}

/* ************** 19 . MODIFIER LE PROFIL *****************************/

	public function modifyProfileRequest($userId, $first_name, $name, $email, $description) {
		$db = $this->dbConnect();

		$req = $db->prepare('UPDATE Users SET first_name = ?, last_name = ?, email = ?, description = ? WHERE id = ?');

		$modifiedProfile = $req->execute(array($first_name, $name, $email, $description, $userId));


		return $modifiedProfile;
	}

/* ************** 20 . CHANGE COLOR YELLOW ****************************/

	public function changeColorYellowRequest($userId) {
		$db = $this->dbConnect();

		$req = $db->prepare('UPDATE Users SET color = "yellow" WHERE id = ?');

		$colorYellow = $req->execute(array($userId));

		return $colorYellow;
	}

/* ************** 20 . CHANGE COLOR AQUA ****************************/

	public function changeColorAquaRequest($userId) {
		$db = $this->dbConnect();

		$req = $db->prepare('UPDATE Users SET color = "aqua" WHERE id = ?');

		$colorAqua = $req->execute(array($userId));

		return $colorAqua;
	}
	
}