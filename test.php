<?php

/**** PWD *****/
$PWD_INIT = 'key_pass';
$PWD_KEY = 'azertyuiopqsdfgh';
$PWD_CASE_INSENSITIVE = FALSE;

function keygen($s, $raw_result = FALSE) {
	global $PWD_INIT;
	global $PWD_KEY;
	global $PWD_CASE_INSENSITIVE;
	return hash_hmac('SHA256', $PWD_INIT . ((TRUE === $PWD_CASE_INSENSITIVE) ? strtolower($s) : $s), $PWD_KEY, $raw_result);
}

/*** TEST ***/
if(isset($_POST) && !empty($_POST) && array_key_exists('key', $_POST)) {
	echo keygen(htmlspecialchars($_POST['key']));
	exit();
}
else if(!empty($s = file_get_contents('php://input'))) {
	//if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$data = json_decode($s, true);
	if(array_key_exists('key', $data)) {
		echo keygen($data['key']);
	}
	exit();
}

/**** DB *****/
$host = 'localhost';
$host_user = 'root';
$host_pwd = '';
$db   = 'cabinet';
$charset = 'utf8mb4';

function validateUserPwd($user, $pwd) {
	global $host;
	global $db;
	global $host_user;
	global $host_pwd;
	try {
		$db   = 'cabinet';
		$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $host_user, $host_pwd, [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_EMULATE_PREPARES   => FALSE
		]);
		$sql = "SELECT COUNT(`id`) FROM `person` WHERE (email = :mail AND pwd = :password)";
		$stmt->execute([
			'mail' 	 => $user,
			'password'   => $pwd
		]);
		return (1 === $stmt->rowCount());//fetchColumn()
	} catch (PDOException $e) {
		return FALSE;
	}
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
	<!--
    <link rel="stylesheet" href="styles/index.css"/>
    <link rel="icon" href="images/favicon.png"/>
	-->
	
</head>
<body>
    <header>
        <div id="site_logo">
		<!--
            <img src="images/logo.png" alt="Logo du site" />
		-->
        </div>
        <nav id="links">
            <a href="index.html">Acceuil</a>
        </nav>
    </header>

    <main>
        <h1 id="main_title">Saisie des informations</h1>
        <div id="content">
<?php
$dsn = "mysql:host=$host;dbname=soundwave;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Active les exceptions en cas d'erreur
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // Récupère les résultats sous forme de tableau associatif
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Désactive l'émulation des requêtes préparées (sécurité)
];

try {
    // 1. Connexion à la base de données
    $pdo = new PDO($dsn, $host_user, $host_pwd, $options);
/*
    // 2. Requête préparée avec un marqueur nommé (:id)
    $sql = "SELECT id, nom, email FROM utilisateurs.utilisateur WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // 3. Exécution de la requête en passant les paramètres
    $idRecherche = 1;
    $stmt->execute(['id' => $idRecherche]);

    // 4. Récupération des données
    $utilisateur = $stmt->fetch();

    if ($utilisateur) {
        echo "Nom : " . htmlspecialchars($utilisateur['nom']) . "<br>";
        echo "Email : " . htmlspecialchars($utilisateur['email']) . "<br>";
    } else {
        echo "Aucun utilisateur trouvé.";
    }*/
	$sql = "SELECT * FROM `client`";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	$i = 0;
	while(FALSE !== ($row = $stmt->fetch()) ) {
		$pwd = keygen(sprintf('test_%02u', $i++));
		echo "INSERT INTO `person`(`nom`, `prenom`, `email`, `pwd`, `access`) VALUES ('{$row['nom']}', '{$row['prenom']}', '{$row['email']}', '{$pwd}', 'CLIENT');<br />\n";
		echo "2 Versions pour que mysql stocke en bin<br />\n";
		echo "-- INSERT INTO `person`(`nom`, `prenom`, `email`, `pwd`, `access`) VALUES ('{$row['nom']}', '{$row['prenom']}', '{$row['email']}', UNHEX('{$pwd}'), 'CLIENT');<br />\n";
		echo "-- INSERT INTO `person`(`nom`, `prenom`, `email`, `pwd`, `access`) VALUES ('{$row['nom']}', '{$row['prenom']}', '{$row['email']}', X'{$pwd}', 'CLIENT');<br /><br />\n";

	}
} catch (PDOException $e) {
    // Gestion des erreurs
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}


try {
    $pdo = new PDO("mysql:host=localhost;dbname=$db;charset=utf8mb4", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
	
	$i = 0;
	do {
		$sql = "SELECT `nom`, `prenom` FROM `person` WHERE pwd = :password";
		$stmt = $pdo->prepare($sql);
		
		$s = sprintf('test_%02u', $i++);
		$k = keygen($s);
		$stmt->execute([
			'password'   => $k
		]);
		$row = $stmt->fetch();
		if(FALSE === $row) break;
		echo $row['nom'], ':', $row['prenom'], ':', $s;
		echo "<br />\n";
	}while(1);
	
	
	for($i = 0;$i < 10; $i++) {
		$sql = "SELECT COUNT(`id`) FROM `person` WHERE pwd = :password";
		$s = sprintf('test_%02u', $i);
		$k = keygen($s);
		$stmt->execute([
			'password'   => $k
		]);
		echo 'Key: ', $i, ':', $stmt->rowCount(), "<br />\n";
	}
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}


?>
		<div>
			<div>
				<label for="txt_keygen_key">Key:</label><br />
				<input type="text" id="txt_keygen_key" value="" style="width: 400px"/>
			</div>
			<div>
				<label for="txt_keygen_result">Result:</label><br />
				<input type="text" id="txt_keygen_result" value="" style="width: 400px"/>
			</div>
			<div>
				<input type="button" id="btn_keygen" value="KeyGen"/>
			</div>
		</div>
		
		<div>
			<form id="keyform" action="">
				<div>
					<label for="txt_keygen_key2">Key:</label><br />
					<input type="text" id="txt_keygen_key2" value="somekey" style="width: 400px"/>
				</div>
				<div>
					<label for="txt_keygen_result2">Result:</label><br />
					<input type="text" id="txt_keygen_result2" value="" style="width: 400px"/>
				</div>
				<div>
					<button type="submit" id="btn_keygen2">KeyGen</button>
				</div>
			</form>
		</div>
		
		<script type="text/javascript">
			let btn = document.getElementById('btn_keygen');
			let btn2 = document.getElementById('btn_keygen2');
			let txtin = document.getElementById('txt_keygen_key');
			let txtin2 = document.getElementById('txt_keygen_key');
			let keyform = document.getElementById('keyform');
			
			//btn.addEventListener('click', (e) => {
			txtin.addEventListener('input', (e) => {
				e.preventDefault();
				//let skey = document.getElementById('txt_keygen_key').value;
				let skey = event.currentTarget.value;
				let res = fetch('test.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
						//'Content-Type': 'multipart/form-data'
					},
					body: JSON.stringify({key: skey})
					//body: {key: document.getElementById('txt_keygen_key').value}
				})
				.then(res => res.text())
				.then(data => {
					//console.log(data);
					document.getElementById('txt_keygen_result').value = data;
				})
				;
			});
			
			keyform.addEventListener('submit', (e) => {
				e.preventDefault();

				let skey = document.getElementById('txt_keygen_key2').value.trim();
				var fdata = new FormData();
				fdata.append('a', 'skey');
				
				let res = fetch('test.php', {
					method: 'POST',
					//mode: 'cors',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded'
						//'Content-Type': 'multipart/form-data'
					},
					//body: 'key=' . skey
					body: new URLSearchParams({
						key: skey
					})
				})
				.then(res => res.text())
				.then(data => {
					console.log(data);
					document.getElementById('txt_keygen_result2').value = data;
				})
				.catch( e => {
					console.error(e);
				})
				;
			});
		</script>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Cyril — XxX</p>
    </footer>
</body>
</html>
