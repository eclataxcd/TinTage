<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Calendrier Personnel</title>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Inter&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="cal_perso.css">
</head>
<body>
  <div class="calendar-container">
    <div class="calendar-header">
      <a href="index.php"><img src="retour.png" alt="retour"></a>
      <h1>Calendrier personnel</h1>
      <div class="icon"><a href="calendrier_evenements.php">📅 Ajouter un évènement</a></div>
    </div>
    <?php
      // Démarrage de la session et configuration locale pour les dates en français
      session_start();
      setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra');
      // Définir le mois et l'année en cours 
      $selectday = isset($_GET['selectday']) ? intval($_GET['selectday']) : date('j');
      $month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
      $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
      // Calculer le premier jour du mois
      $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
      $daysInMonth = date('t', $firstDayOfMonth);
      $monthName = strftime('%B', $firstDayOfMonth); 
      $dayOfWeek = date('N', $firstDayOfMonth);
      // Tableau des noms de jours
      $daysOfWeek = [ 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche' ];
      // Précédent et Suivant
      $prevMonth = $month == 1 ? 12 : $month - 1;
      $prevYear = $month == 1 ? $year - 1 : $year;
      $nextMonth = $month == 12 ? 1 : $month + 1;
      $nextYear = $month == 12 ? $year + 1 : $year;
    ?>
    <div class="month-title-wrapper"> 
      <a href="?month=<?= $prevMonth ?>&year=<?= $prevYear ?>">&#8592;</a>
      <span><?= $monthName . ' ' . $year ?></span>
      <a href="?month=<?= $nextMonth ?>&year=<?= $nextYear ?>">&#8594;</a>
    </div>

    <div class="grid" id="calendar-days">
      <?php
        // Affichage des en-têtes des jours de la semaine
        foreach ($daysOfWeek as $day) {
          echo "<div class='day header'>$day</div>";
        }
        // Espaces vides avant le 1er jour
        for ($i = 1; $i < $dayOfWeek; $i++) {
            echo '<div class="day empty"></div>';
        }
        // Afficher les jours
        for ($day = 1; $day <= $daysInMonth; $day++) {
            echo "<a href='?month=$month&year=$year&selectday=$day'>";
            echo '<div class="day">' . $day . '</div></a>';
        }
      ?>
    </div>
  </div>
  <div class="sidebar">
    <div class="frame events-frame">
      <h2 class="title">Personnel</h2>
      <?php
        // Affichage des événements personnels du jour sélectionné
        if (isset($_GET['selectday'])) {
          $selectday = intval($_GET['selectday']);
          echo "<div class='highlight-date' id='selected-date'>". strftime('%A %e %B %Y', mktime(0, 0, 0, $month, $selectday, $year)) ."</div>";
          include('connexion.inc.php');
          $id=$_SESSION['id'];
          $date_selected = sprintf('%04d-%02d-%02d', $year, $month, $selectday);
          try {
            $result = $cnx->query("SELECT * FROM prive.calendrier_perso WHERE id_compte=$id AND date_event='$date_selected'");
            while ($ligne = $result->fetch(PDO::FETCH_OBJ)) {
              $id_event = $ligne->id_event;
              echo "<div class='event'>";
              echo "<b>" . date('H:i', strtotime($ligne->horaire_event)) . "</b>";
              echo $ligne->objet_event . "<br />";
              echo "<div class='remove'><a href='retirer.php?id_event=$id_event'>Retirer</a></div>";
              echo "</div>";
            }
          } catch (PDOException $e) {
            echo "Echec de la requête " ;
          }
        } else {
          echo "<div class='highlight-date' id='selected-date'>Sélectionnez un jour</div>";
        }
      ?>
      </div>
    <div class="frame birthday-frame">
      <h3>Anniversaires</h3>
      <?php
        // Affichage des anniversaires des contacts pour le jour sélectionné
        include('connexion.inc.php');
        $id = $_SESSION['id'];
        // Jour sélectionné ou aujourd'hui si rien n'est sélectionné
        if (isset($_GET['selectday'])) {
          $selected_month = $month;
          $selected_day = intval($_GET['selectday']);
        } else {
          $selected_month = date('n');
          $selected_day = date('j');
        }
        // Format mm-dd pour comparaison
        $selected_md = sprintf('%02d-%02d', $selected_month, $selected_day);

        // Récupérer tous les contacts (compte1 OU compte2 = $id, l'autre est le contact)
        $contacts = $cnx->query("
          SELECT c.prenom, c.date_naissance
          FROM prive.contact ct
          JOIN prive.comptes c 
            ON (c.numid = ct.compte1 AND ct.compte2 = $id)
            OR (c.numid = ct.compte2 AND ct.compte1 = $id)
        ");

        $found = false;
        while ($contact = $contacts->fetch(PDO::FETCH_OBJ)) {
          if ($contact->date_naissance) {
            $anniv_md = date('m-d', strtotime($contact->date_naissance));
            if ($anniv_md == $selected_md) {
              // Calcul de l'âge à la date sélectionnée
              $birthYear = date('Y', strtotime($contact->date_naissance));
              $age = $year - $birthYear;
              echo htmlspecialchars($contact->prenom) . " " . $age . " ans<br>";
              $found = true;
            }
          }
        }
        if (!$found) {
          echo "Aucun anniversaire ce jour";
        }
      ?>
    </div>
  </div>
</body>
</html>
