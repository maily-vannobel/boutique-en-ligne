<?php
require_once __DIR__ . '/../../classes/Subcategories.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subcategories_id = $_POST['subcategories_id'];

    if (!empty($subcategories_id)) {
        $subcategories = new Subcategories();
        $result = $subcategories->deleteSubcategory($subcategories_id);

        if ($result) {
            $response['success'] = true;
            $response['message'] = "La sous-catégorie a été supprimée avec succès.";
        } else {
            $response['message'] = "Erreur lors de la suppression de la sous-catégorie.";
        }
    } else {
        $response['message'] = "L'ID de la sous-catégorie ne peut pas être vide.";
    }
}

echo json_encode($response);
?>
