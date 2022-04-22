<?php

class AllUsers extends DatabaseHandler {

    protected function getAllUsers($order, $sort) {

        $stmt = $this->connect()->prepare('SELECT id_user, first_name, last_name, mail, role_id_role, send_mail FROM user ORDER BY ' . $order .  ' ' . $sort .  ';');

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

        $pagesCount = ceil($stmt->rowCount()/50);

        if(!isset($_GET['page']))
            $page = 1;
        else
            $page = $_GET['page'];

        $thisPageFirstResult = ($page-1)*50;

        $stmt = $this->connect()->prepare('SELECT id_user, first_name, last_name, mail, role_id_role, send_mail FROM user ORDER BY ' . $order .  ' ' . $sort .  ' LIMIT ' . $thisPageFirstResult .  ',50;');

        if(!$stmt->execute(array())) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            return;
        }

        $users = array();

        $dbAllUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if($sort == 'DESC')
            $sort = 'ASC';
        else 
            $sort = 'DESC';

        echo("<table>");
        echo('<tr><th><a href="allUsers.php?order=first_name&sort=' . $sort . '">Křestní jméno</a></th><th><a href="allUsers.php?order=last_name&sort=' . $sort . '">Příjmení</a></th>');
        if(isset($_GET['idCopy']))
            echo ('<th>Vypůjčit</th><th><form method="POST"><button type="submit" name="searchButton" class="button">Vyhledat</button></form></th><th></th><th></th>');
        else
            echo ('<th><a href="allUsers.php?order=mail&sort=' . $sort . '">Mail</a></th><th><a href="allUsers.php?order=role_id_role&sort=' . $sort . '">Role</a></th><th><a href="allUsers.php?order=send_mail&sort=' . $sort . '">Posílání mailů</a></th><th><form method="POST"><button type="submit" name="searchButton" class="button">Vyhledat</button></form></th>');
        if(unserialize($_SESSION['user'])->getRole() == 3)
            echo ('<th></th></tr>');
        else
            echo ('</tr>');

        for ($i = 0; $i < $stmt->rowCount(); $i++) {
            array_push($users, $dbAllUsers[$i]["id_user"]);
            echo("<tr><td>" . $dbAllUsers[$i]["first_name"] . "</td><td>" . $dbAllUsers[$i]["last_name"] . "</td><td>" . $dbAllUsers[$i]["mail"] . "</td>");
            if(isset($_GET['idCopy'])) {
                echo ('<td><form method="POST"><button type="submit1" name="borrowButton" class="button" value="'.$i.'">Vypůjčit</button></form>');
                echo ('<td><form method="POST"><button type="submit1" name="borrowButton1" class="button" value="'.$i.'">Vypůjčit trvale</button></form><td></td>');
            }
            else {
                echo ("<td>" . $dbAllUsers[$i]["role_id_role"] . "</td><td>" . $dbAllUsers[$i]["send_mail"] . "</td>");
            }
            if(unserialize($_SESSION['user'])->getRole() == 3)
                echo ('<td><form method="POST"><button type="submit" name="editButton" class="button" value="'.$i.'">Upravit</button></form></td><td><form method="POST"><button type="submit" name="deleteButton" class="button" value="'.$i.'">Odstranit</button></form></td>');
        }
        echo("</tr></table><br />");

        for ($page = 1; $page <= $pagesCount; $page++) {
            echo('<a href="allUsers.php?page=' . $page . '" class="page">' . $page . '</a>');
        }

        echo("</div>");

        $stmt = null;

        if(isset($_POST["searchButton"])) {

            header('Location: allUsersSearch.php');
        }

        if(isset($_POST["borrowButton"])) {

            $idUser = $users[$_POST["borrowButton"]];
            $idLentBy = unserialize($_SESSION['user'])->getIdUser();
            $idCopy = $_GET["idCopy"];

            $stmt = $this->connect()->prepare('INSERT INTO borrowing(user_id_user, copy_id_copy, from_date, extended, user_id_lent_by, lasting) VALUES(?, ?, ?, ?, ?, ?);');
        
            if(!$stmt->execute(array($idUser, $idCopy, date("Y-m-d"), 0, $idLentBy, 0))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            header('Location: allBooks.php');
        }

        if(isset($_POST["borrowButton1"])) {

            $idUser = $users[$_POST["borrowButton1"]];
            $idLentBy = unserialize($_SESSION['user'])->getIdUser();
            $idCopy = $_GET["idCopy"];

            $stmt = $this->connect()->prepare('INSERT INTO borrowing(user_id_user, copy_id_copy, from_date, extended, user_id_lent_by, lasting) VALUES(?, ?, ?, ?, ?, ?);');
        
            if(!$stmt->execute(array($idUser, $idCopy, date("Y-m-d"), 0, $idLentBy, 1))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            header('Location: allBooks.php');
        }

        if(isset($_POST["editButton"])) {

            $idUser = $users[$_POST["editButton"]];

            $stmt = $this->connect()->prepare('SELECT first_name, last_name, mail, role_id_role FROM user WHERE id_user = ?;');
        
            if(!$stmt->execute(array($idUser))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                return;
            }

            $dbUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $firstName = $dbUsers[0]["first_name"];
            $lastName = $dbUsers[0]["last_name"];
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

            header('Location: addUser.php?firstName=' . $firstName . '&lastName=' . $lastName . '&mail=' . $mail . '&role='. $role);
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