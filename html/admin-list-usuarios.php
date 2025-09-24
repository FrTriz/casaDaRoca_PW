<?php
require_once '../php/Funcoes/verifica-admin.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários - Admin</title>
    <link rel="stylesheet" href="../css/style-admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
    
<style>
    .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            width: 50%;
            border-radius: 8px;
        }
        .close {
            float: right;
            cursor: pointer;
            font-size: 24px;
        }

      
        </style>
</head>

<body>

       <?php
        include 'admin-header.php';
    ?>

    <main>
        <section class="secao-conteudo">
            <h1 class="admin-title">Gerenciar Usuários</h1>
            <p class="admin-subtitle">Lista de todos os usuários registrados no site.</p>

            <div class="tabela-admin-container">
                <table class="tabela-admin">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Tipo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once '../php/conexao.php';
                        try {
                            $sql = "SELECT u.id_usuario, u.email, u.tipo, c.nome 
                                    FROM usuario u 
                                    LEFT JOIN cliente c ON u.id_usuario = c.id_cliente 
                                    ORDER BY u.id_usuario";
                            $stmt = $pdo->query($sql);
                            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($usuarios as $usuario) {
                                echo "<tr>
                                        <td>{$usuario['id_usuario']}</td>
                                        <td>{$usuario['nome']}</td>
                                        <td>{$usuario['email']}</td>
                                        <td>{$usuario['tipo']}</td>
                                        <td>
                                            <button class='btn-editar' data-id='{$usuario['id_usuario']}' data-nome='{$usuario['nome']}' data-email='{$usuario['email']}' data-tipo='{$usuario['tipo']}' title='Editar'><i class='fa-solid fa-pen'></i></button>
                                            <button class='btn-excluir' data-id='{$usuario['id_usuario']}' title='Excluir'><i class='fa-solid fa-trash-can'></i></button>
                                        </td>
                                      </tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='5'>Erro ao carregar usuários</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Modal de Edição -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Usuário</h2>
            <form id="editForm" action="../php/Funcoes/editar-usuario.php" method="POST">
                <input type="hidden" id="editId" name="id">
                
                <label for="editNome">Nome:</label>
                <input type="text" id="editNome" name="nome" required>
                
                <label for="editEmail">Email:</label>
                <input type="email" id="editEmail" name="email" required>
                
                <label for="editTipo">Tipo:</label>
                <select id="editTipo" name="tipo" required>
                    <option value="cliente">Cliente</option>
                    <option value="administrador">Administrador</option>
                </select>
                
                <button type="submit" class="botao">Salvar Alterações</button>
            </form>
        </div>
    </div>

        <?php
        include 'admin-footer.php';
    ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('editModal');
        const closeBtn = document.querySelector('.close');
        const editForm = document.getElementById('editForm');

        // Abrir modal de edição
        document.querySelectorAll('.btn-editar').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('editId').value = this.dataset.id;
                document.getElementById('editNome').value = this.dataset.nome;
                document.getElementById('editEmail').value = this.dataset.email;
                document.getElementById('editTipo').value = this.dataset.tipo;
                modal.style.display = 'block';
            });
        });

        // Fechar modal
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Fechar ao clicar fora
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Excluir usuário
        document.querySelectorAll('.btn-excluir').forEach(btn => {
            btn.addEventListener('click', function() {
                if (confirm('Tem certeza que deseja excluir este usuário?')) {
                    const id = this.dataset.id;
                    window.location.href = `../php/Funcoes/excluir-usuario.php?id=${id}`;
                }
            });
        });
    });
    </script>
</body>
</html>