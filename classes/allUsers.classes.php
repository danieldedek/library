<?php

class AllUsers extends DatabaseHandler {

    protected function getAllUsers() {

        $stmt = $this->connect()->prepare('SELECT id_user, first_name, key_name, mail, role_id_role, send_mail FROM user;');

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

        $pagesCount = ceil($stmt->rowCount()/2);

        if(!isset($_GET['page']))
            $page = 1;
        else
            $page = $_GET['page'];

        $thisPageFirstResult = ($page-1)*2;

        $stmt = $this->connect()->prepare('SELECT id_user, first_name, key_name, mail, role_id_role, send_mail FROM user LIMIT ' . $thisPageFirstResult .  ',2;');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        $users = array();

        $dbAllUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo("<table>");
        echo("<tr><th>Křestní jméno</th><th>Příjmení</th><th>Mail</th><th>Role</th><th>Posílání mailů</th></tr>");
        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($users, $dbAllUsers[$i]["id_user"]);
            echo("<tr><td>" . $dbAllUsers[$i]["first_name"] . "</td><td>" . $dbAllUsers[$i]["key_name"] . "</td><td>" . $dbAllUsers[$i]["mail"] . "</td><td>" . $dbAllUsers[$i]["role_id_role"] . "</td><td>" . $dbAllUsers[$i]["send_mail"] . '</td><td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td><td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td></tr>');
        }
        echo("</table>");

        for ($page = 1; $page <= $pagesCount; $page++) {
            echo('<a href="allUsers.php?page=' . $page . '">' . $page . '</a>');
        }

        echo("</div>");

        $stmt = null;

        if(isset($_POST["editButton"])) {

            $idUser = $users[$_POST["editButton"]];

            $stmt = $this->connect()->prepare('SELECT first_name, key_name, mail, role_id_role FROM user WHERE id_user = ?;');
        
            if(!$stmt->execute(array($idUser))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $dbUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $firstName = $dbUsers[0]["first_name"];
            $keyName = $dbUsers[0]["key_name"];
            $mail = $dbUsers[0]["mail"];
            $idRole = $dbUsers[0]["role_id_role"];

            $stmt = $this->connect()->prepare('SELECT name FROM role WHERE id_role = ?;');
        
            if(!$stmt->execute(array($idRole))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $dbRole = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $role = $dbRole[0]["name"];

            header('Location: addUser.php?firstName=' . $firstName . '&keyName=' . $keyName . '&mail=' . $mail . '&role='. $role);
        }

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