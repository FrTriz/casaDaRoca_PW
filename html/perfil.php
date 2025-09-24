<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa da Roça - Produtos Naturais</title>
    <link rel="stylesheet" href="../css/style-cliente.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Open+Sans&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5eb066ef2f.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        include 'cliente-header.php';
    ?>

    <main>
    <section class="secao-conteudo">
        <h1 class="form-title">Meu Perfil</h1>
        
        <form action="salvar-perfil.php" method="POST" class="perfil-form">
            <h2>Dados Pessoais</h2>
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" value="<?php echo 'Nome do Usuário'; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="<?php echo 'email@usuario.com'; ?>" required>
            </div>

            <h2 style="margin-top: 2rem;">Endereço</h2>
            <div class="form-group-duplo">
                <div class="form-group">
                    <label for="rua">Rua</label>
                    <input type="text" id="rua" name="rua" value="<?php echo 'Nome da Rua'; ?>" required>
                </div>
                <div class="form-group">
                    <label for="numero">Número</label>
                    <input type="text" id="numero" name="numero" value="<?php echo 'Número da Casa'; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="cidade">Cidade</label>
                <input type="text" id="cidade" name="cidade" value="<?php echo 'Feira de Santana'; ?>" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado</label>
                <input type="text" id="estado" name="estado" value="<?php echo 'BA'; ?>" required>
            </div>
            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" id="cep" name="cep" value="<?php echo '00000-000'; ?>" required>
            </div>
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="tel" id="telefone" name="telefone" value="<?php echo '75999999999'; ?>" required>
            </div>

            <div class="form-group-acoes" style="text-align: center; margin-top: 2rem;">
                <button type="submit" class="botao">Salvar Alterações</button>
            </div>
        </form>
    </section>
    </main>

    <?php
        include 'cliente-footer.php';
    ?>
</body>
</html>