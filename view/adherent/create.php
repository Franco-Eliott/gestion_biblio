<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Adhérent</title>
    <script src="../../css/tailwindCSS@4.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <div class="bg-white p-6 rounded shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold mb-4">Ajouter un Adhérent</h1>
                <a href="../dashboard.php" class="text-blue-500 hover:underline">Retour au Tableau de Bord</a>
            </div>
            <form action="../../controller/AdherentController.php?action=create" method="POST">
                <div class="mb-4">
                    <label for="nom" class="block text-gray-700 font-medium">Nom</label>
                    <input type="text" id="nom" name="nom" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="adresse" class="block text-gray-700 font-medium">Adresse</label>
                    <textarea id="adresse" name="adresse" class="w-full border border-gray-300 rounded px-3 py-2" required></textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
