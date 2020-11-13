<?php
session_start();

if ( ! isset( $_SESSION['usuario_id'] ) ) {
    header("Location: login.php");
}

include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    
    $id = NULL;
    
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : date('d-m-Y');
    $cliente = isset($_POST['cliente']) ? $_POST['cliente'] : '';
    $valor = isset($_POST['valor']) ? $_POST['valor'] : '';
    $cuotas = isset($_POST['cuotas']) ? $_POST['cuotas'] : '';
    $interes = isset($_POST['interes']) ? $_POST['interes'] : '';
    $valor_cuota = isset($_POST['valor_cuota']) ? $_POST['valor_cuota'] : '';
    $cobrador = isset($_POST['cobrador']) ? $_POST['cobrador'] : '';
    $saldo = isset($_POST['saldo']) ? $_POST['saldo'] : '';
    
    $stmt = $pdo->prepare('INSERT INTO creditos VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $fecha, $cliente, $valor, $cuotas, $interes, $valor_cuota, $cobrador, $saldo]);
    
    $msg = 'Creado satisfactoriamente!';
}
?>

<?=template_header('Crear')?>

<div class="content update">
	<h2>Crear credito</h2>
    <form action="create.php" method="post">
        <label for="fecha">Fecha</label>
        <label for="cliente">Cliente</label>
        <input type="date" name="fecha" value="<?=date('Y-m-d')?>" id="fecha">
        <input type="text" name="cliente" placeholder="Jorge Noriega" id="cliente">
        <label for="valor">Valor</label>
        <label for="cuotas">Cuotas</label>
        <input type="number" name="valor" placeholder="1000000" min="0" id="valor">
        <input type="number" name="cuotas" placeholder="12" min="0" id="cuotas">
        <label for="interes">Interes</label>
        <label for="valor_cuota">Valor cuota</label>
        <input type="number" name="interes" placeholder="7" min="0" id="interes">
        <input type="number" name="valor_cuota" placeholder="90000" min="0" id="valor_cuota">
        <label for="cobrador">Cobrador</label>
        <label for="saldo">Saldo</label>
        <input type="text" name="cobrador" placeholder="Miguel Valbuena" id="cobrador">
        <input type="number" name="saldo" placeholder="9100000" min="0" id="saldo">
        <input type="submit" value="Guardar">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>