<?php

class AllUsers extends DatabaseHandler {

    protected function getAllUsers() {

        $stmt = $this->connect()->prepare(
        'SELECT id_user, first_name, key_name, mail, role_id_role, send_mail FROM user;');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        if($stmt->rowCount() == 0) {
            $stmt = null;
            echo '<div class="wrapper"><p>Žádní uživatelé v databázi</p></div>';
            return;
        }

        $users = array();

        $dbAllUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo("<table>");
        echo("<tr><th>Křestní jméno</th><th>Příjmení</th><th>Mail</th><th>Role</th><th>Souhlas s posíláním mailů</th></tr>");
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($users, $dbAllUsers[$i]["id_user"]);
            echo("<tr><td>" . $dbAllUsers[$i]["first_name"] . "</td><td>" . $dbAllUsers[$i]["key_name"] . "</td><td>" . $dbAllUsers[$i]["mail"] . "</td><td>" . $dbAllUsers[$i]["role_id_role"] . "</td><td>" . $dbAllUsers[$i]["send_mail"] . '</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td><td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
        }
        echo("</table></div>");

        $stmt = null;

        if(isset($_POST["deleteButton"])) {

            $idUser = $users[$_POST["deleteButton"]];
        
            $stmt = $this->connect()->prepare('DELETE FROM user WHERE id_user = ?;');
        
            if(!$stmt->execute(array($idUser))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $stmt = null;
            
            header("Refresh:0");

        }
    }
}
?>