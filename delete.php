<?php
session_start();

if ( ! isset( $_SESSION['usuario_id'] ) ) {
    header("Location: login.php");
}

include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) {
    
    $stmt = $pdo->prepare('SELECT * FROM creditos WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $credito = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$credito) {
        exit('No existe un credito con ese ID!');
    }
    
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            
            $stmt = $pdo->prepare('DELETE FROM creditos WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Eliminado satisfactoriamente!';
            
        } else {
            
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Eliminar')?>

<div class="content delete">
	<h2>Eliminar credito #<?=$credito['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>¿Esta seguro que quiere eliminar el credito #<?=$credito['id']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$credito['id']?>&confirm=yes">Si</a>
        <a href="delete.php?id=<?=$credito['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>