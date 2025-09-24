<?php
class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function buscarDados($id_usuario) {
        $sql = "SELECT c.nome, u.email, u.tipo FROM usuario u JOIN cliente c ON u.id_usuario = c.id_cliente WHERE u.id_usuario = :id_usuario";
        $cmd = $this->pdo->prepare($sql);
        $cmd->bindParam(':id_usuario', $id_usuario);
        $cmd->execute();

        return $cmd->fetch(PDO::FETCH_ASSOC);
    }

    public function logOut() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header('Location: ../html/login.php');
        exit();
    }   
}