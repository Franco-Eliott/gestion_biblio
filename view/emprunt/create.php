<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer un Emprunt</title>
    <script src="../../css/tailwindCSS@4.js"></script>
</head>
<body class="bg-gray-100">
    <?php require_once '../../service.php'; ?>
    <div class="container mx-auto mt-10">
        <!-- Affichage des messages -->
        <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-4 p-4 rounded <?= $_SESSION['error']['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
            <?= $_SESSION['error']['message'] ?>
        </div>
        <?php unset($_SESSION['error']); endif; ?>
        <!-- Formulaire -->
        <div class="bg-white p-6 rounded shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Enregistrer un Emprunt</h1>
                <a href="../dashboard.php" class="text-blue-500 hover:underline">Retour au Tableau de Bord</a>
            </div>
            <form action="../../controller/EmpruntController.php?action=create" method="POST">
                <!-- Sélection de l'adhérent -->
                <div class="mb-4">
                    <label for="id_adh" class="block text-gray-700 font-medium">Adhérent</label>
                    <select id="id_adh" name="id_adh" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        <option value="" disabled selected>-- Sélectionnez un adhérent --</option>
                        <?php foreach ($adherentdb->readAll() as $adherent): ?>
                        <option value="<?= $adherent->id_adh ?>" <?= $adherent->is_suspendu ? 'disabled style="color:gray;"' : '' ?>>
                            <?= $adherent->nom ?> - <?= $adherent->adresse ?><?= $adherent->is_suspendu ? ' (suspendu)' : '' ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Sélection des livres -->
                <div class="mb-4">
                    <label for="livres" class="block text-gray-700 font-medium">Livres à emprunter</label>
                    <div class="border border-gray-300 rounded px-3 py-2 max-h-40 overflow-y-auto">
                        <?php foreach ($livredb->readAll() as $livre): ?>
                        <?php if ($livre->is_dispo && $livre->nbr_exemplaire > 0): ?>
                        <div class="flex items-center mb-2">
                            <input type="checkbox" id="livre_<?= $livre->ref_livre ?>" name="livres[]" value="<?= $livre->ref_livre ?>" class="mr-2">
                            <label for="livre_<?= $livre->ref_livre ?>" class="text-gray-700"><?= $livre->titre ?> - <?= $livre->editeur ?> (<?= $livre->nbr_exemplaire ?> exemplaire(s) disponible(s))</label>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- Bouton d'enregistrement -->
                <div class="text-right">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>