<?php
require_once '../service.php';

$action = $_GET['action']; // Récupère l'action à effectuer (create, return, history)

try {
    if ($action == 'create') {
        $id_adh = $_POST['id_adh'];
        $livres = $_POST['livres'];
        $date_emp = date('Y-m-d');
        $duree = 14;
        $date_retour_prevue = date('Y-m-d', strtotime("+$duree days", strtotime($date_emp)));

        // Vérifier suspension adhérent
        $adherent = $adherentdb->read($id_adh);
        if ($adherent && $adherent->is_suspendu) {
            set_error('danger', 'Cet adhérent est suspendu et ne peut pas emprunter de livres.');
            header('Location: ../view/emprunt/create.php');
            exit;
        }

        if (empty($id_adh) || empty($livres)) {
            set_error('danger', 'Veuillez sélectionner un adhérent et au moins un livre.');
            header('Location: ../view/emprunt/create.php');
            exit;
        }

        $id_emp = $empruntdb->create($id_adh, $date_emp, $date_retour_prevue);

        if ($id_emp) {
            foreach ($livres as $ref_livre) {
                $empruntdb->addLivreToEmprunt($id_emp, $ref_livre);
                $livredb->decrementExemplaire($ref_livre);
            }
            set_error('success', 'Emprunt enregistré avec succès.');
        } else {
            set_error('danger', 'Erreur lors de l\'enregistrement de l\'emprunt.');
        }

        header('Location: ../view/emprunt/index.php');
        exit;
    }

    if ($action == 'return') {
        $id_emp = $_POST['id_emp'];
        $date_retour = date('Y-m-d');
        $empruntdb->returnEmprunt($id_emp, $date_retour);
        set_error('success', 'Retour enregistré avec succès.');
        header('Location: ../view/emprunt/index.php');
        exit;
    }

    if ($action == 'history') {
        $id_adh = $_GET['key'];
        $historique = $empruntdb->readHistory($id_adh);
        include '../view/emprunt/history.php';
    }
} catch (Exception $e) {
    set_error('danger', 'Erreur dans EmpruntController.php', $e);
    header('Location: ../view/emprunt/index.php');
    exit;
}
?>