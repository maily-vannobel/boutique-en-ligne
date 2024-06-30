<?php
require_once __DIR__ . '/../../classes/Filters.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filter_id = $_POST['filter_id'];
    $filter_type = $_POST['filter_type'];
    $filter_value = $_POST['filter_value'];

    if (!empty($filter_id) && !empty($filter_type) && !empty($filter_value)) {
        $filters = new Filters();
        $result = $filters->updateFilter($filter_id, $filter_type, $filter_value);

        if ($result) {
            $response['success'] = true;
            $response['message'] = "Le filtre a été mis à jour avec succès.";
        } else {
            $response['message'] = "Erreur lors de la mise à jour du filtre.";
        }
    } else {
        $response['message'] = "L'ID du filtre, le type de filtre et la valeur du filtre ne peuvent pas être vides.";
    }
}

echo json_encode($response);
?>
