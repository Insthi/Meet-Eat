<?php
session_start();
require 'db.php';

$id_question = isset($_GET['q']) ? (int)$_GET['q'] : 0;

/* --- ENREGISTREMENT DE LA RÉPONSE --- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['choix'])) {
    $id_q_repondue = (int)$_POST['id_question_actuelle'];
    $choix_index = (int)$_POST['choix'];

    // Récupération du texte de la réponse
    $stmt_text = $pdo->prepare("SELECT choix_$choix_index FROM quiz_amitie WHERE id_question = ?");
    $stmt_text->execute([$id_q_repondue]);
    $rep_texte = $stmt_text->fetchColumn();

    if ($rep_texte && isset($_SESSION['id_user'])) {
        // Nettoyage avant insertion pour éviter le Duplicate Entry
        $del = $pdo->prepare("DELETE FROM reponse_quiz WHERE id_user = ? AND id_question = ? AND type_quiz = 'amitie'");
        $del->execute([$_SESSION['id_user'], $id_q_repondue]);

        // Insertion du texte
        $ins = $pdo->prepare("INSERT INTO reponse_quiz (id_user, id_question, type_quiz, reponse) VALUES (?, ?, 'amitie', ?)");
        $ins->execute([$_SESSION['id_user'], $id_q_repondue, $rep_texte]);
    }

    header("Location: quizfriends.php?q=" . ($id_q_repondue + 1));
    exit;
} 

/* --- PROGRESSION ET RÉCUPÉRATION --- */
$total_questions = $pdo->query("SELECT COUNT(*) FROM quiz_amitie")->fetchColumn();

if ($id_question === 0) { 
    $_SESSION['reponses_amitie'] = []; 
}

$requete = $pdo->prepare("SELECT * FROM quiz_amitie WHERE id_question = ?");
$requete->execute([$id_question]);
$question = $requete->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meet-Eat – Quiz Amitié</title>
    <link rel="stylesheet" href="quiz_styles.css">
</head>

<body class="theme-amitie">

    <div class="header-logo">
        <a href="choix.php">
            <img src="IMAGES/logomeeteat_inverse.png" alt="Logo">
        </a>
    </div>

    <main class="quiz-container">

        <?php if ($id_question === 0) : ?>

            <h1 class="question-display" style="font-size: 1.3rem; font-weight: 400; text-align: left;">
                En répondant à ces quelques questions sur vos préférences culinaires 
                et vos envies de rencontre amicale, vous nous permettez de vous 
                proposer des profils qui font sens pour vous.
            </h1>

            <a href="quizfriends.php?q=1" class="btn-main" style="width: 250px; margin: 0 auto;">
                Je me lance !
            </a>

        <?php elseif ($id_question > 0 && !$question) : ?>

            <div class="validation-box">
                <h1 class="question-display" style="font-size: 2.2rem; margin-bottom: 20px;">Vos réponses ont bien été enregistrées !</h1>
                
                <p class="congrats-text" style="font-size: 1.3rem; line-height: 1.6; margin-bottom: 50px;">
                    Nous avons tout ce qu’il faut <br>
                    pour vous faire correspondre au mieux avec nos utilisateurs.
                </p>

                <div class="form-actions" style="flex-direction: column; gap: 20px;">
                    <a href="index-test.php" class="btn-main">Réserver maintenant</a>
                    <a href="profil.php" class="btn-sub">Voir mon profil</a>
                </div>
            </div>

        <?php else : ?>

            <div class="progress-info">
                QUESTION <?= $id_question ?> SUR <?= $total_questions ?>
            </div>

            <div class="progression-bar-container">
                <div class="bar-bg">
                    <?php $pourcentage = ($id_question / $total_questions) * 100; ?>
                    <div class="bar-fill" style="width: <?= $pourcentage ?>%;"></div>
                </div>
            </div>

            <h1 class="question-display">
                <?= htmlspecialchars($question['question']) ?>
            </h1>

            <form method="POST" action="quizfriends.php?q=<?= $id_question ?>" autocomplete="off">
                <input type="hidden" name="id_question_actuelle" value="<?= $id_question ?>">
                
                <div class="options-wrapper">

                    <?php for($i=1; $i<=3; $i++): ?>
                        <?php if(!empty($question["choix_$i"])): ?>
                            
                            <label class="option-card">
                                <input type="radio" name="choix" value="<?= $i ?>" required>
                                <div class=\"design-pill\">
                                    <?= htmlspecialchars($question["choix_$i"]) ?>
                                </div>
                            </label>

                        <?php endif; ?>
                    <?php endfor; ?>

                </div>

                <div class="form-actions">
                    <?php if ($id_question > 1) : ?>
                        <a href="quizfriends.php?q=<?= $id_question - 1 ?>" class="btn-sub">
                            Question précédente
                        </a>
                    <?php else : ?>
                        <a href="quizfriends.php?q=0" class="btn-sub">
                            Précédent
                        </a>
                    <?php endif; ?>
                    
                    <button type="submit" class="btn-main">
                        <?= ($id_question == $total_questions) ? "Valider" : "Suivant" ?>
                    </button>
                </div>

            </form>

        <?php endif; ?>

    </main>

    <img src="IMAGES/pizza.png" alt="" class="bg-decor">

</body>
</html>