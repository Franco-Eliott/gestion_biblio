<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retour d'un Emprunt</title>
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
                <h1 class="text-2xl font-bold">Retour d'un Emprunt</h1>
                <a href="../dashboard.php" class="text-blue-500 hover:underline">Retour au Tableau de Bord</a>
            </div>
            <?php
            $id_emp = isset($_GET['key']) ? $_GET['key'] : null;
            $emprunt = null;
            if ($id_emp) {
                // On récupère l'emprunt
                $emprunt = $empruntdb->read($id_emp);
                // On récupère l'adhérent associé
                if ($emprunt && isset($emprunt->id_adh)) {
                    $adherent = $adherentdb->read($emprunt->id_adh);
                    $emprunt->nom_adherent = $adherent ? $adherent->nom : '';
                } else {
                    $emprunt->nom_adherent = 'error';
                }
                // Correction : récupérer les livres associés à l'emprunt via une méthode publique
                $queryLivres = "SELECT l.titre FROM concerner c JOIN livre l ON c.ref_livre = l.ref_livre WHERE c.id_emp = ?";
                // Utiliser une connexion temporaire à la base (éviter l'accès direct à $empruntdb->db)
                $db = new PDO('mysql:host=localhost;dbname=biblio_gestion', 'root', '');
                $stmt = $db->prepare($queryLivres);
                $stmt->execute([$id_emp]);
                $emprunt->livres = $stmt->fetchAll(PDO::FETCH_OBJ);
            }
            ?>
            <?php if ($emprunt): ?>
            <form action="../../controller/EmpruntController.php?action=return" method="POST">
                <input type="hidden" name="id_emp" value="<?= htmlspecialchars($emprunt->id_emp) ?>">
                <div class="mb-4">
                    <label for="adherent" class="block text-gray-700 font-medium">Adhérent</label>
                    <input type="text" id="adherent" value="<?= htmlspecialchars($emprunt->nom_adherent) ?>" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" readonly>
                </div>
                <div class="mb-4">
                    <label for="date_emp" class="block text-gray-700 font-medium">Date d'Emprunt</label>
                    <input type="text" id="date_emp" value="<?= htmlspecialchars($emprunt->date_emp) ?>" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100" readonly>
                </div>
                <div class="mb-4">
                    <label for="livres" class="block text-gray-700 font-medium">Livres Empruntés</label>
                    <ul class="list-disc pl-5">
                        <?php if (!empty($emprunt->livres)): ?>
                            <?php foreach ($emprunt->livres as $livre): ?>
                            <li><?= htmlspecialchars($livre->titre) ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="text-gray-500 italic">Aucun livre associé</li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="text-right">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Enregistrer le Retour</button>
                </div>
            </form>
            <?php else: ?>
                <div class="text-red-600 font-bold">Aucun emprunt trouvé.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>