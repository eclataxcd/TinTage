<?php
$month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

// Connexion DB
$pdo = new PDO("mysql:host=localhost;dbname=agenda_db;charset=utf8", "root", "");

// Récupération des événements
$stmt = $pdo->prepare("SELECT event_date, title FROM events WHERE MONTH(event_date) = ? AND YEAR(event_date) = ?");
$stmt->execute([$month, $year]);
$events = [];
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $event) {
    $day = (int)date('j', strtotime($event['event_date']));
    $events[$day][] = $event['title'];
}

// Calcul du premier jour et du nombre de jours
$firstDayOfMonth = date('w', strtotime("$year-$month-01")); // 0 (dim) à 6 (sam)
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// Rendu HTML
echo "<table border='1'><tr>";
$days = ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'];
foreach ($days as $day) echo "<th>$day</th>";
echo "</tr><tr>";

$dayCounter = 0;
// Blancs avant le 1er jour
for ($i = 0; $i < $firstDayOfMonth; $i++) {
    echo "<td></td>";
    $dayCounter++;
}

for ($day = 1; $day <= $daysInMonth; $day++) {
    $eventText = isset($events[$day]) ? "<ul><li>" . implode("</li><li>", $events[$day]) . "</li></ul>" : "";
    echo "<td><strong>$day</strong>$eventText</td>";
    $dayCounter++;
    if ($dayCounter % 7 == 0) echo "</tr><tr>";
}

while ($dayCounter % 7 != 0) {
    echo "<td></td>";
    $dayCounter++;
}
echo "</tr></table>";
?>
