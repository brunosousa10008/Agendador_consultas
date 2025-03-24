<?php

class Consulta{
    private $pdo;

    public function __construct(){
        $db = new Pdo();
        $this->pdo = $db->getPDO();
    }

    function criarConsulta($paciente_id, $datahora, $consulta_tipo_id, $medico_id, $laudo, $atualizado_por) {
        $sql = "INSERT INTO tbConsulta (paciente_id, datahora, consulta_tipo_id, medico_id, laudo, atualizado_por, atualizado_em) VALUES (:paciente_id, :datahora, :consulta_tipo_id, :medico_id, :laudo, :atualizado_por, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":paciente_id", $paciente_id, PDO::PARAM_INT);
        $stmt->bindValue(":datahora", $datahora, PDO::PARAM_STR);
        $stmt->bindValue(":consulta_tipo_id", $consulta_tipo_id, PDO::PARAM_INT);
        $stmt->bindValue(":medico_id", $medico_id, PDO::PARAM_INT);
        $stmt->bindValue(":laudo", $laudo, PDO::PARAM_STR);
        $stmt->bindValue(":atualizado_por", $atualizado_por, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    function lerConsultas() {
        $sql = "SELECT * FROM tbConsulta";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function atualizarConsulta($id, $laudo, $atualizado_por) {
        $sql = "UPDATE tbConsulta SET laudo = :laudo, atualizado_em = NOW(), atualizado_por = :atualizado_por WHERE consulta_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":laudo", $laudo, PDO::PARAM_STR);
        $stmt->bindValue(":atualizado_por", $atualizado_por, PDO::PARAM_INT);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    function deletarConsulta($id) {
        $sql = "DELETE FROM tbConsulta WHERE consulta_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}