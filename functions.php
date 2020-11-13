<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'creditos_db';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	
        exit('Fallo al conectar la base de datos!');
    }
}
function template_header($title) {
echo <<<EOT
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>$title</title>
    <link href="app.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
    <nav class="navtop">
    	<div>
            <h1>Creditos CRUD</h1>
            <a href="index.php"><i class="fas fa-home"></i>Inicio</a>
            <a href="read.php"><i class="fas fa-address-book"></i>Creditos</a>     
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Cerrar sesión</a>
    	</div>
    </nav>
EOT;
}

function template_footer() {
    echo <<<EOT
    </body>
</html>
EOT;
}
?>
