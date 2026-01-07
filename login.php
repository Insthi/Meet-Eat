<?php
session_start();
require 'db.php'; // On récupère la connexion $pdo

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // 1. On cherche l'utilisateur par son email
        $stmt = $pdo->prepare("SELECT id_user, mot_de_passe FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // 2. Si l'utilisateur existe, on vérifie le mot de passe
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            // Succès : On enregistre l'ID en session
            $_SESSION['id_user'] = $user['id_user'];
            
            // Redirection vers le profil
            header('Location: profil.php');
            exit;
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet Eat - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .serif-title { font-family: 'Playfair Display', serif; }
        .bg-cream { background-color: #fdf6e9; }
        .bg-dark-red { background-color: #4a130a; }
        .text-dark-red { color: #4a130a; }
    </style>
</head>
<body class="bg-dark-red flex flex-col items-center justify-center min-h-screen relative overflow-hidden">

    <div class="absolute -bottom-20 -left-20 opacity-10">
        <svg width="400" height="400" fill="white" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
    </div>

    <div class="bg-cream w-full max-w-md p-10 rounded-[40px] shadow-2xl z-10 mx-4">
        <h1 class="serif-title text-3xl text-dark-red text-center mb-10">Se connecter</h1>

        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-6 text-center text-sm">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php" class="space-y-8">
            <div>
                <label class="block text-dark-red font-bold text-lg mb-2">Email</label>
                <input type="email" name="email" required class="w-full p-4 rounded-2xl bg-white border-none shadow-inner text-black" placeholder="votre@email.com">
            </div>

            <div>
                <label class="block text-dark-red font-bold text-lg mb-2">Mot de passe</label>
                <input type="password" name="password" required class="w-full p-4 rounded-2xl bg-white border-none shadow-inner text-black" placeholder="••••••••">
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-dark-red text-white py-4 rounded-2xl font-bold text-xl hover:opacity-90 transition shadow-lg">
                    Connexion
                </button>
            </div>
        </form>

        <p class="text-center text-dark-red mt-8 text-sm">
            Pas encore de compte ? <a href="inscription.php" class="font-bold border-b border-dark-red">S'inscrire</a>
        </p>
    </div>

</body>
</html>