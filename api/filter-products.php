<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once '../classes/Database.php';
require_once '../classes/Products.php';
require_once '../classes/Images.php';

$products = new Products();
$images = new Images();

// Fonction de gestion des erreurs
function handle_error($errno, $errstr, $errfile, $errline) {
    http_response_code(500);
    echo json_encode(['error' => "$errstr in $errfile on line $errline"]);
    exit();
}
set_error_handler('handle_error');

// Récupérer les filtres depuis la requête
$filters = json_decode(file_get_contents('php://input'), true);

if ($filters === null && json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Erreur de décodage JSON']);
    exit();
}

// Construire la requête SQL en fonction des filtres
$query = "SELECT DISTINCT p.* FROM products p 
          LEFT JOIN product_filter pf ON p.product_id = pf.product_id 
          LEFT JOIN filters f ON pf.filter_id = f.filter_id 
          WHERE 1=1";

$params = [];
if (!empty($filters['couleur'])) {
    $placeholders = implode(',', array_fill(0, count($filters['couleur']), '?'));
    $query .= " AND (f.filter_type = 'couleur' AND f.filter_value IN ($placeholders))";
    $params = array_merge($params, $filters['couleur']);
}

if (!empty($filters['ingrédient'])) {
    $placeholders = implode(',', array_fill(0, count($filters['ingrédient']), '?'));
    $query .= " AND (f.filter_type = 'ingrédient' AND f.filter_value IN ($placeholders))";
    $params = array_merge($params, $filters['ingrédient']);
}

if (!empty($filters['marque'])) {
    $placeholders = implode(',', array_fill(0, count($filters['marque']), '?'));
    $query .= " AND (f.filter_type = 'marque' AND f.filter_value IN ($placeholders))";
    $params = array_merge($params, $filters['marque']);
}

// Exécuter la requête
$stmt = $products->getDatabaseConnection()->prepare($query);
if ($stmt->execute($params)) {
    $filtered_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($filtered_products as &$product) {
        $product_images = $images->getImagesByProductId($product['product_id']);
        $product['image_url'] = !empty($product_images) ? $product_images[0]['url'] : null;
    }
    echo json_encode(['products' => $filtered_products]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de l\'exécution de la requête SQL']);
}
?>
