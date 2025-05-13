<?php
require_once '../service.php';

$action = $_GET['action']; // Récupère l'action à effectuer (create, update, delete)

if ($action == 'create') {
    // Création d'un nouveau livre
    $titre = $_POST['titre'];
    $editeur = $_POST['editeur'];
    $prix = $_POST['prix'];
    $nbr_exemplaire = $_POST['nbr_exemplaire'];

    $livredb->create($titre, $editeur, $prix, $nbr_exemplaire); // Appelle la méthode pour insérer un nouveau livre

    // Message de succès
    $_SESSION['error'] = array(
        'type' => 'success',
        'message' => 'Livre ajouté avec succès.'
    );
    header('Location: ../view/livre/index.php'); // Redirection vers la liste des livres
}

if ($action == 'update') {
    // Mise à jour des informations d'un livre existant
    $ref_livre = $_POST['ref_livre'];
    $titre = $_POST['titre'];
    $editeur = $_POST['editeur'];
    $prix = $_POST['prix'];
    $nbr_exemplaire = $_POST['nbr_exemplaire'];

    $livredb->update($ref_livre, $titre, $editeur, $prix, $nbr_exemplaire); // Appelle la méthode pour mettre à jour le livre

    // Message de succès
    $_SESSION['error'] = array(
        'type' => 'success',
        'message' => 'Livre modifié avec succès.'
    );
    header('Location: ../view/livre/index.php'); // Redirection vers la liste des livres
}

if ($action == 'delete') {
    // Suppression logique d'un livre
    $ref_livre = $_GET['key'];

    $livredb->delete($ref_livre); // Appelle la méthode pour marquer le livre comme supprimé

    // Message de succès
    $_SESSION['error'] = array(
        'type' => 'success',
        'message' => 'Livre supprimé avec succès.'
    );
    header('Location: ../view/livre/index.php'); // Redirection vers la liste des livres
}
?>
