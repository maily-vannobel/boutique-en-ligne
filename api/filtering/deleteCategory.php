<?php
require_once __DIR__ . '/../../classes/Categories.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];

    if (!empty($category_id)) {
        $categories = new Categories();
        $result = $categories->deleteCategory($category_id);

        if ($result) {
            $response['success'] = true;
            $response['message'] = "La catégorie a été supprimée avec succès.";
        } else {
            $response['message'] = "Erreur lors de la suppression de la catégorie.";
        }
    } else {
        $response['message'] = "L'ID de la catégorie ne peut pas être vide.";
    }
}

echo json_encode($response);
?>
