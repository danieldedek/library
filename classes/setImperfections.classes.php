<?php

class SetImperfections extends DatabaseHandler {

    protected function getImperfections($oldISBN) {

        $imperfections = array();

        $stmt = $this->connect()->prepare(
            'SELECT id_copy FROM copy WHERE ISBN = ?;');
    
        $stmt->execute(array($oldISBN));
        $dbImperfections = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $idCopy = $dbImperfections[0]["id_copy"];

        $stmt = $this->connect()->prepare(
            'SELECT to_repair.copy_id_copy, imperfection.name
            FROM imperfection
            INNER JOIN  to_repair
            ON imperfection.id_imperfection = to_repair.imperfection_id_imperfection
            WHERE to_repair.copy_id_copy = ?;');
    
        $stmt->execute(array($idCopy));

        $dbImperfections = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($imperfections, $dbImperfections[$i]["name"]);
        }
        return $imperfections;
    }
}
?>