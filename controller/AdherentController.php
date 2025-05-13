<?php
require_once '../service.php';

$action = $_GET['action']; // Récupère l'action à effectuer (create, update, delete, suspend, unsuspend)

if ($action == 'create') {
    // Création d'un nouvel adhérent
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];

    $adherentdb->create($nom, $adresse); // Appelle la méthode pour insérer un nouvel adhérent

    // Message de succès
    $_SESSION['error'] = array(
        'type' => 'success',
        'message' => 'Adhérent ajouté avec succès.'
    );
    header('Location: ../view/adherent/index.php'); // Redirection vers la liste des adhérents
}

if ($action == 'update') {
    // Mise à jour des informations d'un adhérent existant
    $id_adh = $_POST['id_adh'];
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];

    $adherentdb->update($id_adh, $nom, $adresse); // Appelle la méthode pour mettre à jour l'adhérent

    // Message de succès
    $_SESSION['error'] = array(
        'type' => 'success',
        'message' => 'Adhérent modifié avec succès.'
    );
    header('Location: ../view/adherent/index.php'); // Redirection vers la liste des adhérents
}

if ($action == 'delete') {
    // Suppression logique d'un adhérent
    $id_adh = $_GET['key'];

    $adherentdb->delete($id_adh); // Appelle la méthode pour marquer l'adhérent comme supprimé

    // Message de succès
    $_SESSION['error'] = array(
        'type' => 'success',
        'message' => 'Adhérent supprimé avec succès.'
    );
    header('Location: ../view/adherent/index.php'); // Redirection vers la liste des adhérents
}

if ($action == 'suspend') {
    $id_adh = $_GET['key'];
    $adherentdb->suspend($id_adh, true);

    // Récupérer infos adhérent et emprunts en cours
    $adherent = $adherentdb->read($id_adh);
    $emprunts = $empruntdb->readAll();
    $emprunts_adh = [];
    foreach ($emprunts as $emp) {
        if ($emp->id_adh == $id_adh && !$emp->is_returned) {
            $emprunts_adh[] = $emp;
        }
    }
    // Mettre à jour le fichier XML
    require_once '../utils/SuspendedAdherentXML.php';
    try {
        SuspendedAdherentXML::add($adherent, $emprunts_adh);
        $_SESSION['error'] = array(
            'type' => 'success',
            'message' => 'Adhérent suspendu avec succès.'
        );
    } catch (Exception $e) {
        set_error('danger', "Erreur lors de la mise à jour du fichier XML (suspension).", $e);
    }
    header('Location: ../view/adherent/index.php');
    exit;
}

if ($action == 'unsuspend') {
    $id_adh = $_GET['key'];
    $adherentdb->suspend($id_adh, false);

    // Supprimer du fichier XML
    require_once '../utils/SuspendedAdherentXML.php';
    try {
        SuspendedAdherentXML::remove($id_adh);
        $_SESSION['error'] = array(
            'type' => 'success',
            'message' => 'Adhérent réactivé avec succès.'
        );
    } catch (Exception $e) {
        set_error('danger', "Erreur lors de la suppression du fichier XML (réactivation).", $e);
    }
    header('Location: ../view/adherent/index.php');
    exit;
}
?>
