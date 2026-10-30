<?php
// Disable caching
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies



require_once __DIR__ . '/controllers/Controllers.php';

$page = $_GET['page'] ?? 'accueil';

switch ($page) {
    case 'accueil':
        //$controller = new HomeController();
		$controller = new Controllers('home');
        $controller->view();
        break;

    case 'rendez-vous':
        //$controller = new RendezVousController();
        $controller = new Controllers('rdv');
        $controller->view();
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}

?>
