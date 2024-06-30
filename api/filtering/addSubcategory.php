<?php
require_once __DIR__ . '/../../classes/Subcategories.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subcategories_name = $_POST['subcategories_name'];
    $category_id = $_POST['category_id'];

    if (!empty($subcategories_name) && !empty($category_id)) {
        $subcategories = new Subcategories();
        $result = $subcategories->addSubcategory($subcategories_name, $category_id);

        if ($result) {
            $response['success'] = true;
            $response['message'] = "La sous-catégorie \"$subcategories_name\" a été ajoutée avec succès.";
        } else {
            $response['message'] = "Erreur lors de l'ajout de la sous-catégorie.";
        }
    } else {
        $response['message'] = "Le nom de la sous-catégorie et l'ID de la catégorie ne peuvent pas être vides.";
    }
}

echo json_encode($response);
?>
