<?php
session_start();

if ( ! isset( $_SESSION['usuario_id'] ) ) {
    header("Location: login.php");
}

include 'functions.php';

$pdo = pdo_connect_mysql();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

$records_per_page = 5;


$stmt = $pdo->prepare('SELECT * FROM creditos ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();


$creditos = $stmt->fetchAll(PDO::FETCH_ASSOC);


$num_creditos = $pdo->query('SELECT COUNT(*) FROM creditos')->fetchColumn();
?>

<?= template_header('Listado') ?>

<div class="content read">
    <h2>Listado de creditos</h2>
    <a href="create.php" class="create-contact">Registrar creditos</a>
    <table>
        <thead>
            <tr>
                <th scope="col"># ID</th>
                <th scope="col">Fecha</th>
                <th scope="col">Cliente</th>
                <th scope="col">Valor</th>
                <th scope="col">Cuotas</th>
                <th scope="col">Interes</th>
                <th scope="col">Valor cuota</th>
                <th scope="col">Cobrador</th>
                <th scope="col">Saldo</th>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($creditos as $credito): ?>
                <tr>
                    <td><?= $credito['id'] ?></td>
                    <td><?= $credito['fecha'] ?></td>
                    <td><?= $credito['cliente'] ?></td>
                    <td><?= $credito['valor'] ?></td>
                    <td><?= $credito['cuotas'] ?></td>
                    <td><?= $credito['interes'] ?></td>
                    <td><?= $credito['valor_cuota'] ?></td>
                    <td><?= $credito['cobrador'] ?></td>
                    <td><?= $credito['saldo'] ?></td>
                    <td class="actions">
                        <a href="update.php?id=<?= $credito['id'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                        <a href="delete.php?id=<?= $credito['id'] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="read.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
        <?php endif; ?>
        <?php if ($page * $records_per_page < $num_creditos): ?>
            <a href="read.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
            <?php endif; ?>
    </div>
</div>

<?= template_footer()?>