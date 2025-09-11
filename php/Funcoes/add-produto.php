<?php
require_once '../Classes/ProdutoClass.php';
require_once '../conexao.php';

// A lógica só deve rodar para requisições POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Coleta os dados do formulário (exceto a imagem por enquanto)
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];
    $id_categoria = $_POST['categoria'];
    $imagemConteudo = null; // Inicia a variável da imagem como nula

    // Processa e redimensiona a imagem PRIMEIRO
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $caminhoTemporario = $_FILES['imagem']['tmp_name'];

        // Bloco de Redimensionamento 
        $larguraPadrao = 500;
        $alturaPadrao = 500;

        list($larguraOriginal, $alturaOriginal) = getimagesize($caminhoTemporario);
        $imagemOriginal = imagecreatefromstring(file_get_contents($caminhoTemporario));
        $imagemPadronizada = imagecreatetruecolor($larguraPadrao, $alturaPadrao);

        imagecopyresampled(
            $imagemPadronizada, $imagemOriginal,
            0, 0, 0, 0,
            $larguraPadrao, $alturaPadrao,
            $larguraOriginal, $alturaOriginal
        );

        ob_start();
        imagejpeg($imagemPadronizada, null, 85);
        $imagemConteudo = ob_get_clean(); // A imagem redimensionada está aqui

        imagedestroy($imagemOriginal);
        imagedestroy($imagemPadronizada);
        
    } else {
        // Imagem obrigatória, redireciona com erro
        header("Location: ../../html/admin-produtos.php?erro=imagem_obrigatoria");
        exit();
    }

    try {
        // Tenta cadastrar o produto com a IMAGEM JÁ REDIMENSIONADA
        $produto = new Produto($pdo);
        
        // Passa a variável $imagemConteudo, que contém a imagem processada
        if ($produto->cadastrar($nome, $descricao, $preco, $estoque, $imagemConteudo, $id_categoria)) {
            header("Location: ../../html/admin-produtos.php?status=cadastrado");
            exit(); 
        } else {
            header("Location: ../../html/admin-produtos.php?erro=produto_existente");
            exit(); 
        }
    } catch (Exception $e) {
        header("Location: ../../html/admin-produtos.php?erro=db");
        exit();
    }
}

// Se o método não for POST, redireciona para a página principal do admin
header("Location: ../../html/admin-produtos.php");
exit();
?>