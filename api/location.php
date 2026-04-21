<?php
header('Content-Type: application/json');

$address = "Femøvej 3, 4700 Næstved";

echo json_encode([
    "address" => $address,
    "google_maps_url" => "https://www.google.com/maps/dir/?api=1&destination=" . urlencode($address)

]);