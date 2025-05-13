<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Emprunts</title>
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
        <!-- Contenu principal -->
        <div class="bg-white p-6 rounded shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Gestion des Emprunts</h1>
                <a href="../dashboard.php" class="text-blue-500 hover:underline">Retour au Tableau de Bord</a>
            </div>
            <a href="create.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">Enregistrer un Emprunt</a>
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Adhérent</th>
                        <th class="border border-gray-300 px-4 py-2">Date d'Emprunt</th>
                        <th class="border border-gray-300 px-4 py-2">Livres</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empruntdb->readAll() as $emprunt): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2"><?= $emprunt->id_emp ?></td>
                        <td class="border border-gray-300 px-4 py-2">
                            <?= $emprunt->nom_adherent ?>
                            <?php
                            // Affiche " (suspendu)" si l'adhérent est suspendu
                            $adh = $adherentdb->read($emprunt->id_adh);
                            if ($adh && $adh->is_suspendu) {
                                echo '<span class="text-red-600 font-bold"> (suspendu)</span>';
                            }
                            ?>
                        </td>
                        <td class="border border-gray-300 px-4 py-2"><?= $emprunt->date_emp ?></td>
                        <td class="border border-gray-300 px-4 py-2">
                            <ul>
                                <?php if (!empty($emprunt->livres)): ?>
                                    <?php foreach ($emprunt->livres as $livre): ?>
                                    <li><?= $livre->titre ?></li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="text-gray-500 italic">Aucun livre associé</li>
                                <?php endif; ?>
                            </ul>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="return.php?key=<?= $emprunt->id_emp ?>" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Retour</a>
                            <a href="history.php?key=<?= $emprunt->id_emp ?>" class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">Historique</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
