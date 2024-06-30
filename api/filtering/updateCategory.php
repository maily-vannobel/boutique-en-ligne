<?php
require_once __DIR__ . '/../../classes/Categories.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];

    if (!empty($category_id) && !empty($category_name)) {
        $categories = new Categories();
        $result = $categories->updateCategory($category_id, $category_name);

        if ($result) {
            $response['success'] = true;
            $response['message'] = "La catégorie a été mise à jour avec succès.";
        } else {
            $response['message'] = "Erreur lors de la mise à jour de la catégorie.";
        }
    } else {
        $response['message'] = "L'ID de la catégorie et le nom de la catégorie ne peuvent pas être vides.";
    }
}

echo json_encode($response);
?>
