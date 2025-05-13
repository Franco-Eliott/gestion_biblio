<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Adhérent</title>
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
                <h1 class="text-2xl font-bold mb-4">Modifier un Adhérent</h1>
                <a href="../dashboard.php" class="text-blue-500 hover:underline">Retour au Tableau de Bord</a>
            </div>
            <?php $adherent = $adherentdb->read($_GET['key']); ?>
            <?php if (isset($adherent) && $adherent->is_suspendu): ?>
                <div class="mb-4 p-4 rounded bg-red-100 text-red-700">
                    Cet adhérent est actuellement <b>suspendu</b>.
                </div>
            <?php endif; ?>
            <form action="../../controller/AdherentController.php?action=update" method="POST">
                <input type="hidden" name="id_adh" value="<?= $adherent->id_adh ?>">
                <div class="mb-4">
                    <label for="nom" class="block text-gray-700 font-medium">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?= $adherent->nom ?>" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="adresse" class="block text-gray-700 font-medium">Adresse</label>
                    <textarea id="adresse" name="adresse" class="w-full border border-gray-300 rounded px-3 py-2" required><?= $adherent->adresse ?></textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
