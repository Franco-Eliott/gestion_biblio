<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Adhérents</title>
    <script src="../../css/tailwindCSS@4.js"></script>
</head>
<body class="bg-gray-100">
    <?php require_once '../../service.php'; // Inclut le fichier service.php pour initialiser $adherentdb ?>
    <div class="container mx-auto mt-10">
        <!-- Affichage des messages -->
        <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-4 p-4 rounded <?= $_SESSION['error']['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
            <?= $_SESSION['error']['message'] ?>
        </div>
        <?php unset($_SESSION['error']); endif; ?>
        <!-- Contenu principal -->
        <div class="bg-white p-6 rounded shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold mb-4">Liste des Adhérents</h1>
                <a href="../dashboard.php" class="text-blue-500 hover:underline">Retour au Tableau de Bord</a>
            </div>
            <a href="create.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">Ajouter un Adhérent</a>
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Nom</th>
                        <th class="border border-gray-300 px-4 py-2">Adresse</th>
                        <th class="border border-gray-300 px-4 py-2">Statut</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($adherentdb->readAll() as $adherent): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2"><?= $adherent->id_adh ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($adherent->nom) ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($adherent->adresse) ?></td>
                        <td class="border border-gray-300 px-4 py-2">
                            <?php if ($adherent->is_suspendu): ?>
                                <span class="text-red-600 font-bold">Suspendu</span>
                            <?php else: ?>
                                <span class="text-green-600 font-bold">Actif</span>
                            <?php endif; ?>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="update.php?key=<?= $adherent->id_adh ?>" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Modifier</a>
                            <a href="../../controller/AdherentController.php?action=delete&key=<?= $adherent->id_adh ?>" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Supprimer</a>
                            <?php if ($adherent->is_suspendu): ?>
                                <a href="../../controller/AdherentController.php?action=unsuspend&key=<?= $adherent->id_adh ?>" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Réactiver</a>
                            <?php else: ?>
                                <a href="../../controller/AdherentController.php?action=suspend&key=<?= $adherent->id_adh ?>" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Suspendre</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
