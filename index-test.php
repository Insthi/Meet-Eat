<?php session_start(); ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>MEETEAT — Réservations</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
  <div class="app">
  <header>
        <div class="logo-section">
            <img src="IMAGES/logomeeteat.png" alt="Logo">
        </div>
        <nav>
            <a href="accueil.php">Accueil</a>
            <a href="#">Concept</a>
            <a href="#">Catégories</a>
            <a href="index-test.php">Mes réservations</a>
            <a href="#">Contact</a>
        </nav>
        <div class="nav-right">
            <a href="profil.php"><i class="fa-regular fa-user"></i></a>
        </div>
    </header>

    <main class="container">
      <!-- ================= LIST VIEW ================= -->
      <section data-view="list" class="is-active">
        <div class="top-grid">
          <div>
            <div class="searchbar">
              <input id="q" placeholder="Où souhaitez-vous réserver ?" />
              <button class="searchbtn" id="searchBtn" aria-label="Rechercher">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                  <path d="M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" stroke="white" stroke-width="2"/>
                  <path d="M16.5 16.5 21 21" stroke="white" stroke-width="2" stroke-linecap="round"/>
                </svg>
              </button>
            </div>

            <div class="map">
              <iframe
                title="Carte"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                src="https://www.openstreetmap.org/export/embed.html?bbox=2.2241%2C48.8153%2C2.4699%2C48.9022&layer=mapnik">
              </iframe>
            </div>
          </div>

          <aside class="filters">
            <div class="head">
              <span>Filtres</span>
              <small id="quickReset">Réinitialiser</small>
            </div>

            <div class="body">
              <div class="row">
                <div style="font-weight:1000;color:var(--brand);font-size:12px;">Ambiance</div>
                <div class="seg" id="segAmbiance">
                  <button class="pill" data-seg="Expérience">Expérience</button>
                  <button class="pill" data-seg="Immersif">Immersif</button>
                  <button class="pill" data-seg="Gastronomique">Gastronomique</button>
                  <button class="pill" data-seg="Historique">Historique</button>
                  <button class="pill" data-seg="Brunch">Brunch</button>
                </div>
              </div>

              <div class="row">
                <div style="font-weight:1000;color:var(--brand);font-size:12px;">Cuisine</div>
                <label><input type="checkbox" class="f" value="Cuisine française"> Cuisine française</label>
                <label><input type="checkbox" class="f" value="Cuisine méditerranéenne"> Cuisine méditerranéenne</label>
                <label><input type="checkbox" class="f" value="Cuisine alsacienne"> Cuisine alsacienne</label>
                <label><input type="checkbox" class="f" value="Cuisine européenne"> Cuisine européenne</label>
                <label><input type="checkbox" class="f" value="Cuisine coréenne"> Cuisine coréenne</label>
                <label><input type="checkbox" class="f" value="Cuisine régionale"> Cuisine régionale</label>
                <label><input type="checkbox" class="f" value="Brunch"> Brunch</label>
              </div>

              <div class="row">
                <div style="font-weight:1000;color:var(--brand);font-size:12px;">Budget (€/pers)</div>
                <div class="range">
                  <span>10</span>
                  <input id="budget" type="range" min="10" max="60" value="25" />
                  <span id="budgetVal" style="font-weight:1000;color:var(--brand)">25</span>
                </div>
              </div>

              <div class="actions">
                <button class="btn btn-primary" id="applyFilters">Appliquer</button>
                <button class="btn btn-ghost" id="resetFilters">Réinitialiser</button>
              </div>
            </div>
          </aside>
        </div>

        <div class="grid" id="cards"></div>
      </section>

      <!-- ================= DETAILS VIEW ================= -->
      <section data-view="details">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-top:14px;">
          <button class="btn btn-ghost" id="backToList">← Retour</button>
          <div style="color:var(--muted);font-weight:900">Détails du restaurant</div>
          <div style="width:120px"></div>
        </div>

        <div class="details-top" id="detailsRoot"></div>
      </section>

      <!-- ================= CALENDAR VIEW ================= -->
      <section data-view="calendar">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin-top:14px;">
          <button class="btn btn-ghost" id="backToDetails">← Retour</button>
          <div style="color:var(--muted);font-weight:900">Calendrier</div>
          <div style="width:120px"></div>
        </div>

        <div class="cal-wrap">
          <div>
            <div class="cal-card">
              <div class="cal-head">
                <button class="cal-arrow" id="prevMonth" aria-label="Mois précédent">‹</button>
                <div id="monthLabel">Janvier 2026</div>
                <button class="cal-arrow" id="nextMonth" aria-label="Mois suivant">›</button>
              </div>
              <div class="cal-body">
                <div class="dow">
                  <div>Lu</div><div>Ma</div><div>Me</div><div>Je</div><div>Ve</div><div>Sa</div><div>Di</div>
                </div>
                <div class="days" id="days"></div>
              </div>
            </div>

            <div class="program">
              <h3>Programmer</h3>
              <div class="line">
                <div style="display:flex;gap:10px;align-items:center">
                  <span style="width:34px;height:34px;border-radius:12px;background:rgba(107,29,27,.18);border:1px solid rgba(107,29,27,.45);display:grid;place-items:center">📅</span>
                  <div>
                    <div id="progDate" style="font-weight:1000">—</div>
                    <small id="progTime">—</small>
                  </div>
                </div>
                <div style="display:flex;gap:10px;align-items:center">
                  <span style="font-weight:1000;color:var(--brand)" id="progRest">—</span>
                </div>
              </div>

              <div class="foot">
                <div class="muted">Notification</div>
                <div>Recevoir 1 notification 1 jour avant</div>
                <button class="btn btn-secondary" id="editNotif">Modifier</button>
              </div>
            </div>

            <div class="step-actions">
              <button class="btn btn-secondary" id="calBack">Retour</button>
              <button class="btn btn-primary" id="confirm">Suivant</button>
            </div>
          </div>

          <aside class="hours-panel">
            <div class="hp-head">
              <span>Heures disponibles</span>
              <span style="opacity:.85;cursor:pointer" id="collapseHours">▾</span>
            </div>
            <div class="hours-list" id="hoursList"></div>
          </aside>
        </div>
      </section>
    </main>

    <footer class="footer">
      <div class="footer-wrap">
        <div class="footer-social" aria-label="Réseaux sociaux">
          <a class="soc" href="#" aria-label="X" title="X">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 4l16 16M20 4 4 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
          </a>
          <a class="soc" href="#" aria-label="Instagram" title="Instagram">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 7a4 4 0 0 1 4-4h2a4 4 0 0 1 4 4v10a4 4 0 0 1-4 4h-2a4 4 0 0 1-4-4V7Z" stroke="currentColor" stroke-width="2"/><path d="M12 16a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="2"/><path d="M17.5 6.5h.01" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
          </a>
          <a class="soc" href="#" aria-label="YouTube" title="YouTube">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M10 9.5v5l5-2.5-5-2.5Z" fill="currentColor"/><path d="M21 8.2s-.2-1.5-.8-2.1c-.8-.8-1.7-.8-2.1-.9C15.2 5 12 5 12 5h0s-3.2 0-6.1.2c-.4.1-1.3.1-2.1.9C3.2 6.7 3 8.2 3 8.2S2.8 9.9 2.8 11.6v.8c0 1.7.2 3.4.2 3.4s.2 1.5.8 2.1c.8.8 1.9.8 2.4.9 1.7.2 5.8.2 5.8.2s3.2 0 6.1-.2c.4-.1 1.3-.1 2.1-.9.6-.6.8-2.1.8-2.1s.2-1.7.2-3.4v-.8c0-1.7-.2-3.4-.2-3.4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
          </a>
          <a class="soc" href="#" aria-label="LinkedIn" title="LinkedIn">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6.5 9.5V19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M6.5 6.2h.01" stroke="currentColor" stroke-width="4" stroke-linecap="round"/><path d="M10.5 19v-6.2c0-1.9 1.2-3.3 3.1-3.3 1.9 0 2.9 1.3 2.9 3.3V19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </a>
        </div>

        <div class="footer-cols">
          <div class="fcol">
            <div class="fhead">A propos de MeetEat</div>
          </div>
          <div class="fcol">
            <a href="#">Conseils de rencontres</a>
            <a href="#">Aides</a>
          </div>
          <div class="fcol">
            <a href="#">Partenaires</a>
            <a href="#">Tarifs</a>
          </div>
          <div class="fcol">
            <a href="#">Mentions légales</a>
            <a href="#">Signalements</a>
          </div>
        </div>
      </div>

      <div class="footer-bottom">© <span id="year"></span> MeetEat Un site du groupe MeetEat</div>
    </footer>

    <div class="toast" id="toast"></div>

    <div class="modal" id="modal">
      <div class="modal-card">
        <div class="modal-head">
          <span id="modalTitle">Confirmation</span>
          <button class="x" id="closeModal" aria-label="Fermer">✕</button>
        </div>
        <div class="modal-body" id="modalBody"></div>
        <div class="modal-actions">
          <button class="btn btn-ghost" id="cancelModal">Annuler</button>
          <button class="btn btn-primary" id="okModal">Confirmer</button>
        </div>
      </div>
    </div>
  </div>
  <script src="js/app.js" defer></script>
  <script>document.getElementById('year').textContent = new Date().getFullYear();</script>
</body>
</html>
