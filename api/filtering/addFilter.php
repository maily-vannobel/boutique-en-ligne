<?php
require_once __DIR__ . '/../../classes/Filters.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filter_type = $_POST['filter_type'];
    $filter_value = $_POST['filter_value'];

    if (!empty($filter_type) && !empty($filter_value)) {
        $filters = new Filters();
        $result = $filters->addFilter($filter_type, $filter_value);

        if ($result) {
            $response['success'] = true;
            $response['message'] = "Le filtre \"$filter_value\" a été ajouté avec succès.";
        } else {
            $response['message'] = "Erreur lors de l'ajout du filtre.";
        }
    } else {
        $response['message'] = "Le type de filtre et la valeur du filtre ne peuvent pas être vides.";
    }
}

echo json_encode($response);
?>
