<?php
class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function buscarPorId($id_usuario) {
        $sql = "SELECT id_usuario, email, tipo FROM usuario WHERE id_usuario = :id_usuario";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $cmd->execute();
        return $cmd->fetch(PDO::FETCH_ASSOC);
    }

 
    public function atualizarEmail($id_usuario, $email) {
        $sql = "SELECT COUNT(*) FROM Usuario WHERE email = :email AND id_usuario != :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    
  
    public function logOut() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
    }
}
?>