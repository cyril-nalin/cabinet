<?php
if( !isset($_SESSION) ) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet dentaire</title>
    <link rel="stylesheet" href="./assets/css/main.css"/>
    <link rel="icon" href="./assets/images/favicon.ico"/>
    <?php
    if(isset($EXTRA_HTML_HDRS)) {
        echo $EXTRA_HTML_HDRS;
    }
    ?>
</head>
<body>
    <div id="entire_body">
        <header>
            <div id="header_block">
                <div id="header_block_top">
                    <div id="header_block_topl">
                        <img src="./assets/images/logo.png" alt="Logo du site"/>
                    </div>
                    <div id="header_block_topr">
                        <h1>Bienvenue au cabinet dentaire</h1>
                    </div>
                </div>

                <nav id="header_block_bottom">
                    <a href="index.php?page=accueil">Accueil</a>
                    <a href="index.php?page=rendez-vous">Prendre rendez-vous</a>
                    <a href="index.php?page=services">Nos services</a>
                    <a href="index.php?page=about">À propos</a>

                    <a href="index.php?page=about">Gestion</a>
                </nav>

            </div>
        </header>
        <div id="body_content">