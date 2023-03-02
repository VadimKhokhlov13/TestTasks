<?php

$data = json_decode(file_get_contents('php://input'), true);
$count = $data['count'];

$points = [];
for ($i = 0; $i < $count; $i++) {
    $points[] = rand(1, 100);
}

echo json_encode($points);

?>
