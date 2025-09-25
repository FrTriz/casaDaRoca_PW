<?php
require_once __DIR__ . '/../conexao.php';
class Produto {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
        

    public function buscarDados($limite = null) {
    // A SQL base
    $sql = "SELECT p.id_produto, p.nome, p.descricao, p.preco, p.estoque, p.imagem, c.nome AS categoria 
            FROM produto p 
            JOIN categoria c ON p.id_categoria = c.id_categoria 
            ORDER BY p.id_produto";

    // Cláusula LIMIT
    if (is_numeric($limite)) {
        $sql .= " LIMIT " . intval($limite);
    }

    $cmd = $this->pdo->query($sql);
    return $cmd->fetchAll(PDO::FETCH_ASSOC);
}

    public function cadastrar($nome, $descricao, $preco, $estoque, $imagem, $id_categoria) {
    // Verifica se já existe um produto com o mesmo nome
    $cmd = $this->pdo->prepare("SELECT id_produto FROM produto WHERE nome = :n");
    $cmd->bindValue(":n", $nome);
    $cmd->execute();

    if ($cmd->rowCount() > 0) {
        // Se encontrou um produto com o mesmo nome, não cadastra e retorna falso
        return false; 
    } else {
        // Se não existe, insere o novo produto
        $cmd = $this->pdo->prepare("INSERT INTO produto (nome, descricao, preco, estoque, imagem, id_categoria) 
                                     VALUES (:n, :d, :p, :e, :i, :c)");
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":d", $descricao);
        $cmd->bindValue(":p", "{$preco}");
        $cmd->bindValue(":e", $estoque, PDO::PARAM_INT);
        $cmd->bindValue(":i", $imagem, PDO::PARAM_LOB); 
        $cmd->bindValue(":c", $id_categoria, PDO::PARAM_INT);
        $cmd->execute();
        
        // Se a inserção foi bem-sucedida, retorna verdadeiro
        return true; 
    }
}

    public function excluir($id) {
        $cmd = $this->pdo->prepare("DELETE FROM produto WHERE id_produto = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();

    }

   public function atualizar($id, $nome, $descricao, $preco, $estoque, $id_categoria, $imagem = null) {
    try {
        // Monta a parte inicial da query
        $sql = "UPDATE produto SET nome = :n, descricao = :d, preco = :p, estoque = :e, id_categoria = :c";
        
        // Adiciona a atualização da imagem à query APENAS se uma nova imagem foi fornecida
        if ($imagem !== null) {
            $sql .= ", imagem = :i";
        }
        
        // Adiciona a condição WHERE
        $sql .= " WHERE id_produto = :id";

        $cmd = $this->pdo->prepare($sql);

        // Associa os valores aos parâmetros
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":d", $descricao);
        $cmd->bindValue(":p", "{$preco}");
        $cmd->bindValue(":e", $estoque, PDO::PARAM_INT);
        $cmd->bindValue(":c", $id_categoria, PDO::PARAM_INT);
        $cmd->bindValue(":id", $id, PDO::PARAM_INT);

        // Associa o valor da imagem APENAS se ela foi fornecida
        if ($imagem !== null) {
            $cmd->bindValue(":i", $imagem, PDO::PARAM_LOB);
        }

        $cmd->execute();
        return true; // Retorna sucesso

    } catch (PDOException $e) {
        // Opcional: registrar o erro $e->getMessage() em um log
            return false; // Retorna falha
        }
    }

    public function buscarPorId($id) {
        $cmd = $this->pdo->prepare("SELECT * FROM produto WHERE id_produto = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        return $cmd->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorTermo($termo, $id_categoria = null) {
    $termo_busca = '%' . $termo . '%';
    
    // A consulta agora usa unaccent() para ignorar acentos na busca
    $sql = "SELECT p.*, c.nome AS categoria 
            FROM produto p 
            JOIN categoria c ON p.id_categoria = c.id_categoria 
            WHERE (unaccent(p.nome) ILIKE unaccent(:termo) OR unaccent(p.descricao) ILIKE unaccent(:termo))";

    if (!empty($id_categoria)) {
        $sql .= " AND p.id_categoria = :id_categoria";
    }

    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':termo', $termo_busca);

    if (!empty($id_categoria)) {
        $stmt->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>