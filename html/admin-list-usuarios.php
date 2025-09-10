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
                        <tr>
                            <td>1</td>
                            <td>João da Silva</td>
                            <td>joao.silva@exemplo.com</td>
                            <td>Cliente</td>
                            <td>
                                <a href="admin-edit-usuario.html" class="btn-editar" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                <a href="#" class="btn-excluir" title="Excluir"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Ana Garcia</td>
                            <td>ana.garcia@exemplo.com</td>
                            <td>Administrador</td>
                            <td>
                                <a href="admin-edit-usuario.html" class="btn-editar" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                <a href="#" class="btn-excluir" title="Excluir"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <?php
        include 'admin-footer.php';
    ?>
</body>
</html>