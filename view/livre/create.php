<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Livre</title>
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
            <h1 class="text-2xl font-bold mb-4">Ajouter un Livre</h1>
            <form action="../../controller/LivreController.php?action=create" method="POST">
                <div class="mb-4">
                    <label for="titre" class="block text-gray-700 font-medium">Titre</label>
                    <input type="text" id="titre" name="titre" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="editeur" class="block text-gray-700 font-medium">Éditeur</label>
                    <input type="text" id="editeur" name="editeur" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="prix" class="block text-gray-700 font-medium">Prix (FCFA)</label>
                    <input type="number" id="prix" name="prix" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="nbr_exemplaire" class="block text-gray-700 font-medium">Nombre d'exemplaires</label>
                    <input type="number" id="nbr_exemplaire" name="nbr_exemplaire" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="text-right">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
