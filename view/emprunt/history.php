<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Emprunts</title>
    <script src="../../css/tailwindCSS@4.js"></script>
</head>
<body class="bg-gray-100">
    <?php require_once '../../service.php'; // Inclut le fichier service.php pour initialiser $empruntdb ?>
    <div class="container mx-auto mt-10">
        <!-- Affichage des messages -->
        <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-4 p-4 rounded <?= $_SESSION['error']['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
            <?= $_SESSION['error']['message'] ?>
        </div>
        <?php unset($_SESSION['error']); endif; ?>
        <!-- Contenu principal -->
        <div class="bg-white p-6 rounded shadow-md">
            <h1 class="text-2xl font-bold mb-4">Historique des Emprunts</h1>
            <?php $historique = $empruntdb->readHistory($_GET['key']); ?>
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">ID Emprunt</th>
                        <th class="border border-gray-300 px-4 py-2">Date d'Emprunt</th>
                        <th class="border border-gray-300 px-4 py-2">Date de Retour</th>
                        <th class="border border-gray-300 px-4 py-2">Livres</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($historique) && (is_array($historique) || is_object($historique))): ?>
                        <?php foreach ($historique as $emprunt): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-2"><?= $emprunt->id_emp ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $emprunt->date_emp ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $emprunt->date_retour ?? 'Non retourné' ?></td>
                            <td class="border border-gray-300 px-4 py-2">
                                <ul class="list-disc pl-5">
                                    <?php if (!empty($emprunt->livres)): ?>
                                        <?php foreach ($emprunt->livres as $livre): ?>
                                        <li><?= $livre->titre ?></li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <li class="text-gray-500 italic">Aucun livre associé</li>
                                    <?php endif; ?>
                                </ul>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 italic py-4">Aucun historique disponible.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>