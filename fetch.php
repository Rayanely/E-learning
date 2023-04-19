<?php
include 'conn.php';
session_start();

if (!isset($_SESSION['aantal_goed'])) {
    $_SESSION['aantal_goed'] = 0;
}

$data = json_decode(file_get_contents('php://input'), true);

$sql = "SELECT * FROM vragen_elearn WHERE `hoofdstukken_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $data['username']);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_array()) {
    $questions[] = $row;

}
if (empty($questions[$data['vraag']])) {
   
    $last = array("Last" => "Last");
    echo (json_encode($last));
        exit;
}

if ($data['antwoord'] == $questions[$data['vraag'] - 1]['antwoord']) {
    $_SESSION['aantal_goed']++;
}


$questions[$data['vraag']]['aantal_goed'] =   $_SESSION['aantal_goed'];
echo (json_encode($questions[$data['vraag']]));
