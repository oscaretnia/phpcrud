<?php
session_start();

if ( ! isset( $_SESSION['usuario_id'] ) ) {
    header("Location: login.php");
}

include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        
        $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : date('d-m-Y');
        $cliente = isset($_POST['cliente']) ? $_POST['cliente'] : '';
        $valor = isset($_POST['valor']) ? $_POST['valor'] : '';
        $cuotas = isset($_POST['cuotas']) ? $_POST['cuotas'] : '';
        $interes = isset($_POST['interes']) ? $_POST['interes'] : '';
        $valor_cuota = isset($_POST['valor_cuota']) ? $_POST['valor_cuota'] : '';
        $cobrador = isset($_POST['cobrador']) ? $_POST['cobrador'] : '';
        $saldo = isset($_POST['saldo']) ? $_POST['saldo'] : '';
        
        $stmt = $pdo->prepare('UPDATE creditos SET fecha = ?, cliente = ?, valor = ?, cuotas = ?, interes = ?, valor_cuota = ?, cobrador = ?, saldo = ? WHERE id = ?');
        $stmt->execute([$fecha, $cliente, $valor, $cuotas, $interes, $valor_cuota, $cobrador, $saldo, $_GET['id']]);
        $msg = 'Actualizado satisfactoriamente!';
    }
    
    $stmt = $pdo->prepare('SELECT * FROM creditos WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $credito = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$credito) {
        exit('No existe un credito con ese ID!');
    }
} else {
    exit('No se especifico el ID!');
}
?>

<?=template_header('Actualizar')?>

<div class="content update">
	<h2>Actualizar credito #<?=$credito['id']?></h2>
    <form action="update.php?id=<?=$credito['id']?>" method="post">
        <label for="fecha">Fecha</label>
        <label for="cliente">Cliente</label>
        <input type="date" name="fecha" value="<?=date('Y-m-d', strtotime($credito['fecha']))?>" id="fecha">
        <input type="text" name="cliente" placeholder="Jorge Noriega" value="<?=$credito['cliente']?>" id="cliente">
        <label for="valor">Valor</label>
        <label for="cuotas">Cuotas</label>
        <input type="number" name="valor" placeholder="1000000" min="0" value="<?=$credito['valor']?>" id="valor">
        <input type="number" name="cuotas" placeholder="12" min="0" value="<?=$credito['cuotas']?>" id="cuotas">
        <label for="interes">Interes</label>
        <label for="valor_cuota">Valor cuota</label>
        <input type="number" name="interes" placeholder="7" min="0" value="<?=$credito['interes']?>" id="interes">
        <input type="number" name="valor_cuota" placeholder="90000" min="0" value="<?=$credito['valor_cuota']?>" id="valor_cuota">
        <label for="cobrador">Cobrador</label>
        <label for="saldo">Saldo</label>
        <input type="text" name="cobrador" placeholder="Miguel Valbuena" value="<?=$credito['cobrador']?>" id="cobrador">
        <input type="number" name="saldo" placeholder="9100000" min="0" value="<?=$credito['saldo']?>" id="saldo">
        <input type="submit" value="Actualizar">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>