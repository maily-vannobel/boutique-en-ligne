<?php
require_once __DIR__ . '/../../classes/Filters.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filter_id = $_POST['filter_id'];

    if (!empty($filter_id)) {
        $filters = new Filters();
        $result = $filters->removeFilter($filter_id);

        if ($result) {
            $response['success'] = true;
            $response['message'] = "Le filtre a été supprimé avec succès.";
        } else {
            $response['message'] = "Erreur lors de la suppression du filtre.";
        }
    } else {
        $response['message'] = "L'ID du filtre ne peut pas être vide.";
    }
}

echo json_encode($response);
?>
