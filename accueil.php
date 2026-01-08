<?php
session_start();
try {
    $pdo = new PDO("mysql:host=localhost;dbname=v2meet-eat;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $pdo = null;
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>MeetEat — Accueil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;800&family=Gloock&family=Playfair+Display:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="accueil_styles.css" />
    <link rel="stylesheet" href="choix_styles.css" />
</head>
<body>

   <header class="navigation-principale">
    <div class="marque-logo">
        <img src="assets/logomeeteat.png" alt="Logo" class="image-logo">
        <span class="texte-marque">MEET<br>EAT</span>
    </div>
    <nav class="liens-navigation">
        <a href="accueil.php">Accueil</a>
        <a href="chat.php">Discussions</a>
        <a href="#temoignages">Témoignages</a>
        <a href="#">Contact</a>
    </nav>
    <div class="utilisateur-bouton">
    <?php if (isset($_SESSION['id_user'])): ?>
        <a href="profil.php"><button class="bouton-icone-profil">👤</button></a>
    <?php else: ?>
        <a href="login.php"><button class="bouton-icone-profil">👤</button></a>
    <?php endif; ?>
</div>
</header>

    <main>
        <section class="section-hero">
            <div class="contenu-hero">
                <div class="boite-rouge"><h1 class="titre-hero">RENCONTRER</h1></div>
                <div class="boite-rouge"><p class="sous-titre-hero">n'a jamais eu aussi bon goût.</p></div>
                <div class="boite-noire"><p class="phrase-hero">Partagez des ateliers avec ceux qui vous ressemblent.</p></div>
            </div>
        </section>

        <section class="section-concept">
            <div class="conteneur-centre-concept">
                <div class="contenu-concept">
                    <p>Avec Meat & Eat, réalisez des ateliers culinaires en compagnie des personnes qui vous correspondent. Réservez un restaurant à plusieurs, et laissez-vous porter par l'expérience de la cuisine ensemble.</p>
                </div>
            </div>
        </section>

        <div class="split-container">
            <section class="pane love-pane">
                <h1 class="side-title left-align">Vous êtes</h1>
                <div class="content">
                    <div class="emoji">🥂</div>
                    <h2 class="category-title">Amour</h2>
                    <p class="align-right">Choisir l’amour, c’est choisir les frissons et la tendresse. Prêts à fondre comme un chocolat et à faire frétiller les cœurs comme des bulles de champagne ?</p>
                    <a href="quizlove.php" class="btn btn-white">C'est pour moi !</a>
                </div>
            </section>
            <section class="pane friendship-pane">
                <h1 class="side-title right-align">plutôt quoi ?</h1>
                <div class="content">
                    <div class="emoji">🍕</div>
                    <h2 class="category-title">Amitié</h2>
                    <p class="align-right">L’amitié se savoure comme un moment délicieux. Prêts à croquer la vie comme une part de pizza et à remplir les cœurs de joie ?</p>
                    <a href="quizfriends.php" class="btn btn-dark">C'est pour moi !</a>
                </div>
            </section>
        </div>

        <section id="temoignages" class="zone-temoignages">
            <div class="conteneur-temoignages">
                <h2 class="titre-temoignages">Témoignages de nos Eaters :</h2>
                <div class="enveloppe-carrousel">
                    <button class="bouton-nav precedent" id="boutonPrecedent">‹</button>
                    <div class="piste-temoignages" id="pisteCarrousel">
                        <article class="carte-temoignage">
                            <div class="avatar-flottant"><img src="assets/avatar1.png" alt=""></div>
                            <div class="note-croissants">🥐🥐🥐🥐🥐</div>
                            <h4 class="nom-utilisateur">Nora Bernard</h4>
                            <p class="citation">"J'ai adoré cuisiner en groupe, on rigole et on découvre de super recettes !"</p>
                        </article>
                        <article class="carte-temoignage">
                            <div class="avatar-flottant"><img src="assets/avatar2.png" alt=""></div>
                            <div class="note-croissants">🥐🥐🥐🥐🥐</div>
                            <h4 class="nom-utilisateur">Emma Lefèvre</h4>
                            <p class="citation">"Une pépite ! J'ai passé l'une de mes meilleures soirées avec des inconnus géniaux."</p>
                        </article>
                        <article class="carte-temoignage">
                            <div class="avatar-flottant"><img src="assets/avatar3.png" alt=""></div>
                            <div class="note-croissants">🥐🥐🥐🥐🥐</div>
                            <h4 class="nom-utilisateur">Lucas Morel</h4>
                            <p class="citation">"Le concept est top. On oublie vite qu'on ne se connaît pas autour d'un bon plat."</p>
                        </article>
                        <article class="carte-temoignage">
                            <div class="avatar-flottant"><img src="assets/avatar4.png" alt=""></div>
                            <div class="note-croissants">🥐🥐🥐🥐🥐</div>
                            <h4 class="nom-utilisateur">Julie Masson</h4>
                            <p class="citation">"J'ai rencontré des amis incroyables grâce aux ateliers d'amitié. Je recommande !"</p>
                        </article>
                        <article class="carte-temoignage">
                            <div class="avatar-flottant"><img src="assets/avatar5.png" alt=""></div>
                            <div class="note-croissants">🥐🥐🥐🥐🥐</div>
                            <h4 class="nom-utilisateur">Thomas Girard</h4>
                            <p class="citation">"C'est convivial, simple et surtout très bon. Une expérience humaine unique."</p>
                        </article>
                    </div>
                    <button class="bouton-nav suivant" id="boutonSuivant">›</button>
                </div>
                <div class="actions-temoignages">
                    <button class="bouton-avis" id="ouvrirModale">Écrire un commentaire</button>
                </div>
            </div>
        </section>
    </main>

    <div id="modaleCommentaire" class="superposition-modale">
        <div class="contenu-modale modale-feedback">
            <button class="croix-fermer" id="boutonFermerCroix">&times;</button>
            <div class="logo-top-left">
                <img src="assets/logomeeteat.png" alt="M">
                <p>MEET<br>EAT</p>
            </div>

            <div id="etapeFormulaire">
                <h2 class="titre-modale-playfair">Écrire un commentaire :</h2>
                <form id="formulaireCommentaire" class="form-border-box">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Votre nom *</label>
                            <input type="text" name="nom" required>
                        </div>
                        <div class="form-group">
                            <label>Votre prénom *</label>
                            <input type="text" name="prenom" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Votre adresse Email*</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Votre message *</label>
                        <textarea name="message" placeholder="Écrivez votre message ici..." required></textarea>
                    </div>
                    <div class="form-checkbox">
                        <input type="checkbox" id="checkCond" required>
                        <label for="checkCond">J'accepte les conditions</label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn-beige-pill">Envoyer</button>
                    </div>
                </form>
            </div>

            <div id="etapeSucces" style="display: none;">
                <h2 class="titre-modale-playfair">Merci !</h2>
                <p class="msg-confirmation">Votre commentaire a été envoyé avec succès. Merci pour votre contribution.</p>
                <div class="success-buttons">
                    <button class="btn-beige-pill" id="btnReserver">Réserver un restaurant</button>
                    <button class="btn-outline-white" id="btnFermerSimple">Fermer la fenêtre</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const piste = document.getElementById('pisteCarrousel');
        document.getElementById('boutonSuivant').onclick = () => piste.scrollBy({ left: 420, behavior: 'smooth' });
        document.getElementById('boutonPrecedent').onclick = () => piste.scrollBy({ left: -420, behavior: 'smooth' });

        const modale = document.getElementById('modaleCommentaire');
        const etapeForm = document.getElementById('etapeFormulaire');
        const etapeSucces = document.getElementById('etapeSucces');

        document.getElementById('ouvrirModale').onclick = () => { modale.style.display = "flex"; document.body.style.overflow = "hidden"; };
        
        const closeAction = () => { 
            modale.style.display = "none"; 
            document.body.style.overflow = "auto";
            etapeForm.style.display = "block";
            etapeSucces.style.display = "none";
        };

        document.getElementById('boutonFermerCroix').onclick = closeAction;
        document.getElementById('btnFermerSimple').onclick = closeAction;
        document.getElementById('btnReserver').onclick = () => { window.location.href = 'restaurants.php'; };

        document.getElementById('formulaireCommentaire').onsubmit = (e) => {
            e.preventDefault();
            etapeForm.style.display = "none";
            etapeSucces.style.display = "block";
        };
    </script>
</body>
</html>