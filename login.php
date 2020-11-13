<?php
session_start();

if (isset( $_SESSION['usuario_id'] ) ) {
    header("Location: index.php");
}

include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    
    $id = NULL;
    
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $clave = isset($_POST['clave']) ? $_POST['clave'] : '';
    
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE correo = ? AND clave = ? LIMIT 1');
    $stmt->execute([$correo, $clave]);
    $usuario = $stmt->fetch(PDO::FETCH_OBJ);
    
       
    if (!$usuario) {
        $msg = "Credenciales invalidas";
    } else {
        $msg = NULL;
        $_SESSION['usuario_id'] = $usuario->id;
        header("Location: index.php");
    }
}
?>

<?=template_header('Iniciar sesión')?>

<div class="content login">
    <h2>Iniciar sesión</h2>
    <form action="login.php" method="post">
        <label for="email">Correo electrónico</label>
        <input type="email" name="correo" placeholder="jorgenoriega@gmail.com" id="email">
        <label for="password">Contraseña</label>
        <input type="password" name="clave" placeholder="*********"id="password">
        <input type="submit" value="Acceder">
    </form>
    <?php if ($msg): ?>
    <div class="error"><?=$msg?></div>
    <?php endif; ?>
</div>

<?=template_footer()?>