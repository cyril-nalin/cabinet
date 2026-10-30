<?php
// Disable caching
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies



require_once __DIR__ . '/controllers/Controllers.php';

$page = $_GET['page'] ?? 'accueil';
$pages = [
    'accueil' => 'home',
    'rendez-vous' => 'rdv',
    'services' => 'services',
    'about' => 'about',
    'gestion' => 'gestion'
];
$page = strtolower($page);
if(array_key_exists($page, $pages)) {
    try {
        $controller = new Controllers($pages[$page]);
        $controller->view();
    }
    catch(e) {
        var_dump(e);
    }
} else {
    http_response_code(404);
    require __DIR__ . '/views/404.php';
}

?>
