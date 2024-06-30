<?php
require_once __DIR__ . '/../../classes/Subcategories.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subcategories_id = $_POST['subcategories_id'];
    $subcategories_name = $_POST['subcategories_name'];
    $category_id = $_POST['category_id'];

    if (!empty($subcategories_id) && !empty($subcategories_name) && !empty($category_id)) {
        $subcategories = new Subcategories();
        $result = $subcategories->updateSubcategory($subcategories_id, $subcategories_name, $category_id);

        if ($result) {
            $response['success'] = true;
            $response['message'] = "La sous-catégorie a été mise à jour avec succès.";
        } else {
            $response['message'] = "Erreur lors de la mise à jour de la sous-catégorie.";
        }
    } else {
        $response['message'] = "L'ID de la sous-catégorie, le nom de la sous-catégorie et l'ID de la catégorie ne peuvent pas être vides.";
    }
}

echo json_encode($response);
?>
