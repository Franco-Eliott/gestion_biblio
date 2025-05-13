<!-- filepath: /opt/lampp/htdocs/biblio_gestion/view/dashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <script src="../css/tailwindCSS@4.js"></script>
</head>
<body class="bg-gray-100">
    <?php require_once '../service.php'; ?>
    <nav class="bg-blue-500 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <h1 class="text-xl font-bold">Gestion de Bibliothèque</h1>
        </div>
    </nav>
    <div class="container mx-auto mt-10">
        <!-- Affichage des messages -->
        <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-4 p-4 rounded <?= $_SESSION['error']['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
            <?= $_SESSION['error']['message'] ?>
        </div>
        <?php unset($_SESSION['error']); endif; ?>
        <!-- Contenu principal -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Gestion des Adhérents -->
            <div class="bg-white p-6 rounded shadow-md">
                <h2 class="text-xl font-bold mb-4">Gestion des Adhérents</h2>
                <ul class="space-y-2">
                    <li>
                        <a href="adherent/index.php" class="block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Liste des Adhérents</a>
                    </li>
                    <li>
                        <a href="adherent/create.php" class="block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Ajouter un Adhérent</a>
                    </li>
                </ul>
            </div>
            <!-- Gestion des Livres -->
            <div class="bg-white p-6 rounded shadow-md">
                <h2 class="text-xl font-bold mb-4">Gestion des Livres</h2>
                <ul class="space-y-2">
                    <li>
                        <a href="livre/index.php" class="block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Liste des Livres</a>
                    </li>
                    <li>
                        <a href="livre/create.php" class="block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Ajouter un Livre</a>
                    </li>
                </ul>
            </div>
            <!-- Gestion des Emprunts -->
            <div class="bg-white p-6 rounded shadow-md">
                <h2 class="text-xl font-bold mb-4">Gestion des Emprunts</h2>
                <ul class="space-y-2">
                    <li>
                        <a href="emprunt/index.php" class="block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Liste des Emprunts</a>
                    </li>
                    <li>
                        <a href="emprunt/create.php" class="block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Enregistrer un Emprunt</a>
                    </li>
                </ul>
            </div>
            <!-- Historique des Emprunts -->
            <div class="bg-white p-6 rounded shadow-md">
                <h2 class="text-xl font-bold mb-4">Historique des Emprunts</h2>
                <ul class="space-y-2">
                    <li>
                        <a href="emprunt/history.php" class="block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Voir l'Historique</a>
                    </li>
                </ul>
            </div>
            <!-- Retours -->
            <div class="bg-white p-6 rounded shadow-md">
                <h2 class="text-xl font-bold mb-4">Gestion des Retours</h2>
                <ul class="space-y-2">
                    <li>
                        <a href="emprunt/return.php" class="block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Enregistrer un Retour</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>