<?php
if( !isset($_SESSION) ) {
    session_start();
}

// Disable caching
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

$page = $_GET['page'] ?? 'accueil';
$pages = [
    'accueil' => 'home',
    'rendez-vous' => 'rdv',
    'services' => 'services',
    'about' => 'about',
    'gestion' => 'gestion',
    'register' => 'register',
    'membre' => 'membre',
    'login' => 'login',
    'logout' => 'logout'
];


require_once __DIR__ . '/controllers/Controllers.php';

$page = strtolower($page);
if(array_key_exists($page, $pages)) {
    $controller = new Controllers($pages[$page]);
    $controller->view();
} else {
    http_response_code(404);
    require __DIR__ . '/views/404.php';
}

?>
