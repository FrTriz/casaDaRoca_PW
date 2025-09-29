<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Admin</title>
    <link rel="stylesheet" href="/css/style-admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
</head>
<body>

    <?php
        include 'admin-header.php';
    ?>

<main>
    <section class="secao-conteudo">
        <h1 class="admin-title">Pedidos Recentes</h1>
        <p class="admin-subtitle">Lista de todos os pedidos realizados no site.</p>
        
        <div class="tabela-admin-container">
            <table class="tabela-admin">
                <thead>
                    <tr>
                        <th>ID do Pedido</th>
                        <th>Cliente</th>
                        <th>Data do Pedido</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Inclui o arquivo de conexão
                    require_once '/usr/src/app/php/conexao.php';

                    try {
                        // Consulta para buscar os pedidos mais recentes, juntando com a tabela de clientes
                        $query = "
                            SELECT
                                p.id_pedido,
                                c.nome AS nome_cliente,
                                p.data_pedido,
                                p.status
                            FROM
                                pedido p
                            JOIN
                                cliente c ON p.id_cliente = c.id_cliente
                            ORDER BY
                                p.data_pedido DESC
                            LIMIT 10;
                        ";
                        
                        $stmt = $pdo->query($query);
                        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if ($pedidos) {
                            foreach ($pedidos as $pedido) {
                                // Define a classe CSS do status
                                $class_status = '';
                                if ($pedido['status'] == 'pendente') {
                                    $class_status = 'status-pendente';
                                } elseif ($pedido['status'] == 'entregue') {
                                    $class_status = 'status-entregue';
                                }

                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($pedido['id_pedido']) . "</td>";
                                echo "<td>" . htmlspecialchars($pedido['nome_cliente']) . "</td>";
                                echo "<td>" . htmlspecialchars($pedido['data_pedido']) . "</td>";
                                echo "<td><span class='$class_status'>" . htmlspecialchars($pedido['status']) . "</span></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Nenhum pedido encontrado.</td></tr>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='4'>Erro ao carregar pedidos: " . $e->getMessage() . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</main>


    <?php
        include 'admin-footer.php';
    ?>
    <script src="/script.js"></script>
</body>
</html>