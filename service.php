<?php 
	session_start(); //permet d'utiliser les sessions dans tous les fichiers ou 'service.php 'a ete appellé.

	require_once 'model/AdherentDB.php';
	require_once 'model/EmpruntDB.php';
	require_once 'model/LivreDB.php';
	// require_once 'package.php';

	$adherentdb= new AdherentDB();
	$empruntdb= new EmpruntDB();
	$livredb= new LivreDB();
	// $package= new package();

	/**
	 * Gestion centralisée des erreurs pour l'application.
	 * @param string $type (success|danger|warning|info)
	 * @param string $message
	 * @param Exception|null $exception
	 */
	function set_error($type, $message, $exception = null) {
		$details = $message;
		if ($exception instanceof Exception) {
			$details .= "<br><b>Fichier :</b> " . $exception->getFile();
			$details .= "<br><b>Ligne :</b> " . $exception->getLine();
			$details .= "<br><b>Erreur :</b> " . $exception->getMessage();
		}
		$_SESSION['error'] = array(
			'type' => $type,
			'message' => $details
		);
	}
?>