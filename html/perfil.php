<?php
require_once '../php/session-manager.php';
require_once '/usr/src/app/php/conexao.php'; 
require_once '/usr/src/app/php/Classes/UsuarioClass.php';
require_once '/usr/src/app/php/Classes/ClienteClass.php';
require_once '/usr/src/app/php/Classes/PedidoClass.php';

// Garante que o utilizador esteja logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$id_logado = $_SESSION['usuario_id'];

// Instancia os objetos
$usuario_obj = new Usuario($pdo);
$cliente_obj = new Cliente($pdo);
$pedido_obj = new Pedido($pdo);

// Busca as informações 
$usuario_info = $usuario_obj->buscarPorId($id_logado);
$cliente_info = $cliente_obj->buscarPorId($id_logado); 

// Busca o histórico de pedidos do cliente
$pedidos = $pedido_obj->buscarPorCliente($id_logado);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil - Casa da Roça</title>
    
    <link rel="stylesheet" href="/css/style-cliente.css?v=<?php echo time(); ?>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'cliente-header.php'; ?>
    <main>
        <section class="secao-conteudo">
            <h1 class="form-title">Meu Perfil</h1>
            
            <form action="../php/Funcoes/salvar-perfil.php" method="POST" class="perfil-form">
                <h2>Dados Pessoais</h2>
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($cliente_info['nome'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario_info['email'] ?? ''); ?>" required>
                </div>

                <h2 style="margin-top: 2rem;">Endereço</h2>
                <div class="form-group-duplo">
                    <div class="form-group">
                        <label for="rua">Rua</label>
                        <input type="text" id="rua" name="rua" value="<?php echo htmlspecialchars($cliente_info['rua'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="numero">Número</label>
                        <input type="text" id="numero" name="numero" value="<?php echo htmlspecialchars($cliente_info['numero'] ?? ''); ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cidade">Cidade</label>
                    <input type="text" id="cidade" name="cidade" value="<?php echo htmlspecialchars($cliente_info['cidade'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <input type="text" id="estado" name="estado" value="<?php echo htmlspecialchars($cliente_info['estado'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" id="cep" name="cep" value="<?php echo htmlspecialchars($cliente_info['cep'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" value="<?php echo htmlspecialchars($cliente_info['telefone'] ?? ''); ?>" required>
                </div>
                <div class="form-group-acoes" style="text-align: center; margin-top: 2rem;">
                    <button type="submit" class="botao">Salvar Alterações</button>
                </div>
            </form>

            <hr style="margin: 3rem 0;">
            <h2>Meus Pedidos</h2>
            <?php if ($pedidos && count($pedidos) > 0): ?>
                <div class="tabela-carrinho-container">
                    <table class="tabela-carrinho">
                        <thead>
                            <tr>
                                <th>Nº do Pedido</th>
                                <th>Data</th>
                                <th>Valor Total</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $pedido): ?>
                                <tr>
                                    <td>#<?php echo $pedido['id_pedido']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($pedido['data_pedido'])); ?></td>
                                    <td>R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></td>
                                    <td><?php echo ucfirst($pedido['status']); ?></td>
                                    <td><a href="pedido-detalhes.php?id=<?php echo $pedido['id_pedido']; ?>">Ver Detalhes</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p style="text-align: center;">Você ainda não fez nenhum pedido.</p>
            <?php endif; ?>
        </section>
    </main>
    <?php include 'cliente-footer.php'; ?>
        <script src="/script.js"></script>
</body>
</html>