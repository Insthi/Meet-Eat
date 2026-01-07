<?php
session_start();
require 'db.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Récupération des données du formulaire
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $date_naiss = $_POST['date_naissance'];
    $pronoms = $_POST['pronoms'] ?? '';
    $orientation = $_POST['preference'] ?? ''; 
    $biographie = trim($_POST['description']);

    // 2. Vérifications de sécurité
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format d'email invalide.";
    } elseif (strlen($password) < 6) {
        $error = "Le mot de passe doit faire au moins 6 caractères.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $pdo->beginTransaction();

            // 3. Insertion dans la table 'user'
            $stmtUser = $pdo->prepare("INSERT INTO user (email, mot_de_passe, date_creation) VALUES (?, ?, NOW())");
            $stmtUser->execute([$email, $hash]);
            $id_user = $pdo->lastInsertId();

            // 4. Insertion dans la table 'profil'
            $stmtProfil = $pdo->prepare("INSERT INTO profil (id_user, nom, prenom, date_naissance, pronoms, orientation, biographie) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmtProfil->execute([$id_user, $nom, $prenom, $date_naiss, $pronoms, $orientation, $biographie]);

            $pdo->commit();

            // 5. Connexion auto et redirection
            $_SESSION['id_user'] = $id_user;
            header('Location: profil.php');
            exit;

        } catch (PDOException $e) {
            $pdo->rollBack();
            if ($e->getCode() == 23000) {
                $error = "Cet email est déjà utilisé.";
            } else {
                $error = "Erreur : " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet Eat - Créer un compte</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #1a1a2e; }
        .serif-title { font-family: 'Playfair Display', serif; }
        .bg-cream { background-color: #fdf6e9; }
        .bg-dark-red { background-color: #4a130a; }
        .text-dark-red { color: #4a130a; }
        .hobby-checkbox:checked + label { background-color: #c49a8d; color: white; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="bg-cream w-full max-w-4xl rounded-3xl overflow-hidden shadow-2xl relative">
        <div class="absolute top-6 left-8 flex flex-col items-center">
            <div class="text-dark-red font-bold text-xl leading-none">MEET</div>
            <div class="text-dark-red font-bold text-xl leading-none">EAT</div>
        </div>

        <div class="p-8 pt-12">
            <h1 class="serif-title text-4xl text-dark-red text-center mb-6">Créer un compte</h1>

            <?php if ($error): ?>
                <div class="bg-red-500 text-white p-3 rounded-xl mb-4 text-center text-sm">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <div class="bg-dark-red rounded-3xl p-8 text-white">
                <form method="POST" action="inscription.php" enctype="multipart/form-data">
                    <div class="flex items-center gap-4 mb-8">
                        <label for="profile-upload" class="cursor-pointer">
                            <div id="avatar-preview" class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                                <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                            </div>
                        </label>
                        <input type="file" name="photo_profil" id="profile-upload" class="hidden" accept="image/*">
                        <span class="text-sm font-light italic">Ajouter une photo de profil*</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs mb-1">Nom*</label>
                                <input type="text" name="nom" required class="w-full p-2 rounded-xl text-black" placeholder="Moreau">
                            </div>
                            <div>
                                <label class="block text-xs mb-1">Prénom*</label>
                                <input type="text" name="prenom" required class="w-full p-2 rounded-xl text-black" placeholder="Victorine">
                            </div>
                            <div>
                                <label class="block text-xs mb-1">Date de naissance*</label>
                                <input type="date" name="date_naissance" required class="w-full p-2 rounded-xl text-black">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs mb-1">Pronoms</label>
                                <select name="pronoms" class="w-full p-2 rounded-xl text-black">
                                    <option value="" disabled selected>Choisir...</option>
                                    <option value="elle">Elle</option>
                                    <option value="il">Il</option>
                                    <option value="iel">Iel / Neutre</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs mb-1">Que voulez-vous croquer ?*</label>
                                <select name="preference" required class="w-full p-2 rounded-xl text-black">
                                    <option value="" disabled selected>Préférences</option>
                                    <option value="homme">Un Homme</option>
                                    <option value="femme">Une Femme</option>
                                    <option value="les-deux">Les deux</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs mb-1">Description*</label>
                                <textarea name="description" required class="w-full p-2 rounded-xl text-black h-24" placeholder="Parlez-nous de vous..."></textarea>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs mb-3">Hobbies (Sélectionnez)</label>
                            <div class="flex flex-wrap gap-2">
                                <input type="checkbox" name="hobbies[]" value="Cuisine" id="h1" class="hidden hobby-checkbox"><label for="h1" class="bg-white text-dark-red px-3 py-1 rounded-full text-xs cursor-pointer">Cuisine</label>
                                <input type="checkbox" name="hobbies[]" value="Sport" id="h2" class="hidden hobby-checkbox"><label for="h2" class="bg-white text-dark-red px-3 py-1 rounded-full text-xs cursor-pointer">Sport</label>
                                <input type="checkbox" name="hobbies[]" value="Voyage" id="h3" class="hidden hobby-checkbox"><label for="h3" class="bg-white text-dark-red px-3 py-1 rounded-full text-xs cursor-pointer">Voyage</label>
                                <input type="checkbox" name="hobbies[]" value="Lecture" id="h4" class="hidden hobby-checkbox"><label for="h4" class="bg-white text-dark-red px-3 py-1 rounded-full text-xs cursor-pointer">Lecture</label>
                                <button type="button" onclick="toggleModal()" class="bg-[#c49a8d] text-white px-3 py-1 rounded-full text-xs font-bold">Voir plus +</button>
                            </div>
                        </div>

                        <div class="md:col-span-3 flex flex-col items-center mt-4 border-t border-white/20 pt-6">
                            <div class="space-y-4 w-full md:w-1/3">
                                <input type="email" name="email" required class="w-full p-2 rounded-xl text-black" placeholder="Email*">
                                <input type="password" name="password" required class="w-full p-2 rounded-xl text-black" placeholder="Mot de passe*">
                            </div>
                            <button type="submit" class="mt-6 bg-[#c49a8d] text-white px-12 py-2 rounded-full font-semibold hover:bg-[#b08578] transition shadow-lg">Valider l'inscription</button>
                        </div>
                    </div>

                    <div id="hobbyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                        <div class="bg-cream rounded-3xl p-6 max-w-md w-full">
                            <h2 class="serif-title text-2xl text-dark-red mb-4 text-center">Plus de passions</h2>
                            <div class="flex flex-wrap gap-2 mb-6">
                                <?php 
                                $extras = ['Photo', 'Musique', 'Cinéma', 'Jeux Vidéo', 'Peinture', 'Danse', 'Yoga'];
                                foreach($extras as $k => $h): ?>
                                    <input type="checkbox" name="hobbies[]" value="<?= $h ?>" id="ex<?= $k ?>" class="hidden hobby-checkbox">
                                    <label for="ex<?= $k ?>" class="bg-dark-red/10 text-dark-red px-3 py-1 rounded-full text-sm cursor-pointer border border-dark-red/20"><?= $h ?></label>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" onclick="toggleModal()" class="w-full bg-dark-red text-white py-2 rounded-xl font-bold">Terminer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleModal() { document.getElementById('hobbyModal').classList.toggle('hidden'); }
        document.getElementById('profile-upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('avatar-preview').innerHTML = `<img src="${event.target.result}" class="w-full h-full object-cover">`;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>