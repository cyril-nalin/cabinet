<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet dentaire</title>
    <link rel="stylesheet" href="./assets/css/main.css"/>
    <link rel="icon" href="./assets/images/favicon.ico"/>
    <script type="text/javascript" src="./assets/js/main.js"></script>
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

                <nav>
                    <div id="header_block_bottom">
                        <div id="header_block_bottom_reglinks">
                            <a href="index.php?page=accueil">Accueil</a>
                            <?php if(isset($LOG_LEVEL) && $LOG_LEVEL >= 1) {?>
                            <a href="index.php?page=rendez-vous">Prendre rendez-vous</a>
                            <?php }?>
                            <a href="index.php?page=services">Nos services</a>
                            <a href="index.php?page=about">À propos</a>
                        </div>
                        <div id="header_block_bottom_conlinks">
                            <?php if(!isset($LOG_STATE) || FALSE === $LOG_STATE) {?>
                            <input type="button" id="btn_register" value="Inscription" onclick="window.location.assign('index.php?page=register')" />
                            <input type="button" id="btn_connect" value="Connexion" onclick="window.location.assign('index.php?page=login')" />
                            <?php }else {?>
                            <input type="button" id="btn_member" value="Mes infos" onclick="window.location.assign('index.php?page=membre')"/>
                            <input type="button" id="btn_logout" value="Déconnexion" onclick="window.location.assign('index.php?page=logout')"/>
                            <?php }?>
                        </div>
                    </div>
                    <div id="header_block_bottom_adminlinks">
                        <?php
                        if(isset($LOG_LEVEL) && $LOG_LEVEL >= 2) {
                            echo '<p>Gestion: </p>';
                            echo '<a href="index.php?page=gestion">RDV</a>';
                            echo '<a href="index.php?page=gestion&q=news">News</a>';
                            if($LOG_LEVEL >= 3) {
                                echo '<a href="index.php?page=gestion&q=per">Clients</a>';
                                echo '<a href="index.php?page=gestion&q=horaire">Horaires</a>';
                            }
                        }
                        ?>
                    </div>
                </nav>

            </div>
        </header>
        <div id="body_content"><?php 
        if(isset($_SESSION['prenom'])) {
           // echo '<h2>Bienvenue ', $_SESSION['prenom'], '</h2>';
        }
        
        ?>