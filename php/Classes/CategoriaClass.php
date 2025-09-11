<?php
require_once __DIR__ . '/../conexao.php';
    Class Categoria {
        Private $pdo;

        public function __construct(PDO $conexao) {
            $this->pdo = $conexao;
        }
        public function buscarDados() {
            $res = array();
            $cmd = $this->pdo->query("SELECT * FROM categoria ORDER BY id_categoria ");
            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }
        public function cadastrar($nome) {
            // Verifica se já existe uma categoria com o mesmo nome
            $cmd = $this->pdo->prepare("SELECT id_categoria FROM categoria WHERE nome = :n");
            $cmd->bindValue(":n", $nome);
            $cmd->execute();
            if ($cmd->rowCount() > 0) {
                return false; // Categoria já existe
            } else {
                // Insere a nova categoria
                $cmd = $this->pdo->prepare("INSERT INTO categoria (nome) VALUES (:n)");
                $cmd->bindValue(":n", $nome);
                $cmd->execute();
                return true; // Categoria cadastrada com sucesso
            }
        }
        public function excluir($id) {
            $cmd = $this->pdo->prepare("DELETE FROM categoria WHERE id_categoria = :id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();
        }
    public function buscarPorId($id)
    {
        $cmd = $this->pdo->prepare("SELECT * FROM categoria WHERE id_categoria = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        return $cmd->fetch(PDO::FETCH_ASSOC);
    }
    public function atualizar($id, $nome) {
        // Verifica se já existe uma categoria com o mesmo nome, exceto a que está sendo atualizada
        $cmd = $this->pdo->prepare("SELECT id_categoria FROM categoria WHERE nome = :n AND id_categoria != :id");
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        if ($cmd->rowCount() > 0) {
            return false; // Categoria com o mesmo nome já existe
        } else {
            // Atualiza a categoria
            $cmd = $this->pdo->prepare("UPDATE categoria SET nome = :n WHERE id_categoria = :id");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            return true; // Categoria atualizada com sucesso
        }
    }
}
?>