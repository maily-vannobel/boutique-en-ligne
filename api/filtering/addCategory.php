<?php
require_once __DIR__ . '/../../classes/Categories.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = $_POST['category_name'];

    if (!empty($category_name)) {
        $categories = new Categories();
        $result = $categories->addCategory($category_name);

        if ($result) {
            $response['success'] = true;
            $response['message'] = "La catégorie \"$category_name\" a été ajoutée avec succès.";
        } else {
            $response['message'] = "Erreur lors de l'ajout de la catégorie.";
        }
    } else {
        $response['message'] = "Le nom de la catégorie ne peut pas être vide.";
    }
}

echo json_encode($response);
?>
