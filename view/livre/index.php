<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Livres</title>
    <script src="../../css/tailwindCSS@4.js"></script>
</head>
<body class="bg-gray-100">
    <?php require_once '../../service.php'; // Inclut le fichier service.php pour initialiser $livredb ?>
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
                <h1 class="text-2xl font-bold">Gestion des Livres</h1>
                <a href="../dashboard.php" class="text-blue-500 hover:underline">Retour au Tableau de Bord</a>
            </div>
            <a href="create.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">Ajouter un Livre</a>
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Titre</th>
                        <th class="border border-gray-300 px-4 py-2">Éditeur</th>
                        <th class="border border-gray-300 px-4 py-2">Prix</th>
                        <th class="border border-gray-300 px-4 py-2">Stock</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($livredb->readAll() as $livre): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2"><?= $livre->ref_livre ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $livre->titre ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $livre->editeur ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $livre->prix ?> FCFA</td>
                        <td class="border border-gray-300 px-4 py-2"><?= $livre->nbr_exemplaire ?></td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="update.php?key=<?= $livre->ref_livre ?>" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Modifier</a>
                            <a href="../../controller/LivreController.php?action=delete&key=<?= $livre->ref_livre ?>" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
