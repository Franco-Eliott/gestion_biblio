<?php 
	require_once '../service.php';

	$username=$_POST['username'];
	$password=$_POST['password'];

	$user= $userdb->readConnexion($username,$password);

	if ($user == false) {
		$_SESSION['error']= array(
			'type' => 'warning',
			'message' => 'Echec de connexion'
		);
		header('Location: ../index.php');
	}
	else {
		$_SESSION['profil']= $user;
		$_SESSION['error']= array(
			'type' => 'info',
			'message' => 'Bienvenue  '. $user->nom
		);
		header('Location: ../app.php');
	}

	//exemple de Plugin: SWEET ALERT   Faire des recherches dessus.
 ?>