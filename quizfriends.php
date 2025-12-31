<?php
session_start();

/* =============================
   1. Connexion à la base
============================= */
$host = 'localhost';
$dbname = 'v2meet-eat';
$user = 'root';
$pass = ''; 

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

/* =============================
   2. Gestion de la progression
============================= */
$id_question = isset($_GET['q']) ? (int)$_GET['q'] : 0;

// Calcul du total pour la barre de progression
$res_count = $pdo->query("SELECT COUNT(*) FROM quiz_amitie");
$total_questions = $res_count->fetchColumn();

/* =============================
   3. Réinitialisation à l'introduction
============================= */
if ($id_question === 0) {
    $_SESSION['reponses'] = []; // On vide les réponses quand on revient au début
}

/* =============================
   4. Sauvegarde de la réponse
============================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['choix'])) {
    $id_repondue = $id_question - 1;
    if ($id_repondue >= 1) {
        $_SESSION['reponses'][$id_repondue] = $_POST['choix'];
    }
}

/* =============================
   5. Récupération de la question
============================= */
$requete = $pdo->prepare("SELECT * FROM quiz_amitie WHERE id_question = ?");
$requete->execute([$id_question]);
$question = $requete->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet-Eat – Quiz Amical</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="quizfriends_styles.css">
</head>
<body>

<main class="conteneur-quiz">

    <?php if ($id_question === 0) : ?>
        <div class="introduction-quiz">
            <p class="texte-introduction">
                En répondant à ces quelques questions sur vos préférences culinaires
                et vos envies de rencontre, vous nous permettez de vous proposer
                des profils qui font sens pour vous.
            </p>
            <a href="quizfriends.php?q=1" class="bouton bouton-principal">Je me lance !</a>
        </div>

    <?php elseif ($id_question > 0 && !$question) : ?>
        <h1 class="question-quiz">Merci d’avoir répondu au quiz !</h1>
        <div class="resultats-debug">
            <pre><?php print_r($_SESSION['reponses'] ?? []); ?></pre>
        </div>
        <a href="index.php" class="bouton bouton-principal">Retour à l’accueil</a>

    <?php else : ?>
        
        <div class="progression-container">
            <span class="progression-texte">Question <?= $id_question ?> / <?= $total_questions ?></span>
            <div class="barre-fond">
                <?php $pourcentage = ($id_question / $total_questions) * 100; ?>
                <div class="barre-remplissage" style="width: <?= $pourcentage ?>%;"></div>
            </div>
        </div>

        <h1 class="question-quiz"><?= htmlspecialchars($question['question']) ?></h1>

        <?php $reponse_selectionnee = $_SESSION['reponses'][$id_question] ?? null; ?>

        <form method="POST" action="quizfriends.php?q=<?= $id_question + 1 ?>" class="formulaire-quiz" autocomplete="off">
            <div class="liste-reponses">
                <label class="reponse">
                    <input type="radio" name="choix" value="1" <?= ($reponse_selectionnee == 1) ? 'checked' : '' ?> required>
                    <span><?= htmlspecialchars($question['choix_1']) ?></span>
                </label>
                <label class="reponse">
                    <input type="radio" name="choix" value="2" <?= ($reponse_selectionnee == 2) ? 'checked' : '' ?>>
                    <span><?= htmlspecialchars($question['choix_2']) ?></span>
                </label>
                <?php if (!empty($question['choix_3'])) : ?>
                    <label class="reponse">
                        <input type="radio" name="choix" value="3" <?= ($reponse_selectionnee == 3) ? 'checked' : '' ?>>
                        <span><?= htmlspecialchars($question['choix_3']) ?></span>
                    </label>
                <?php endif; ?>
            </div>

            <nav class="navigation-quiz">
                <a href="quizfriends.php?q=<?= ($id_question > 1) ? $id_question - 1 : 0 ?>" class="bouton bouton-secondaire">Précédent</a>
                <button type="submit" class="bouton bouton-principal">Suivant</button>
            </nav>
        </form>
    <?php endif; ?>

</main>

</body>
</html>