<?php

class AddAuthor extends DatabaseHandler {

    protected function checkAuthor($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey, $suffixToKey) {
        if (is_null($prefixToKey) && is_null($namesAfterKey) && is_null($suffixToKey)) {
            $stmt = $this->connect()->prepare('SELECT names_before_key, prefix_to_key, key_name, names_after_key, suffix_to_key FROM author WHERE names_before_key = ? AND prefix_to_key IS NULL AND key_name = ? AND names_after_key IS NULL AND suffix_to_key IS NULL;');
            if(!$stmt->execute(array($namesBeforeKey, $keyName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($prefixToKey) && is_null($namesAfterKey)){
            $stmt = $this->connect()->prepare('SELECT names_before_key, prefix_to_key, key_name, names_after_key, suffix_to_key FROM author WHERE names_before_key = ? AND prefix_to_key IS NULL AND key_name = ? AND names_after_key IS NULL AND suffix_to_key = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $keyName, $suffixToKey))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($prefixToKey) && is_null($suffixToKey)){
            $stmt = $this->connect()->prepare('SELECT names_before_key, prefix_to_key, key_name, names_after_key, suffix_to_key FROM author WHERE names_before_key = ? AND prefix_to_key IS NULL AND key_name = ? AND names_after_key = ? AND suffix_to_key IS NULL;');
            if(!$stmt->execute(array($namesBeforeKey, $keyName, $suffixToKey))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($namesAfterKey) && is_null($suffixToKey)){
            $stmt = $this->connect()->prepare('SELECT names_before_key, prefix_to_key, key_name, names_after_key, suffix_to_key FROM author WHERE names_before_key = ? AND prefix_to_key = ? AND key_name = ? AND names_after_key IS NULL AND suffix_to_key IS NULL;');
            if(!$stmt->execute(array($namesBeforeKey, $prefixToKey, $keyName))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($prefixToKey)){
            $stmt = $this->connect()->prepare('SELECT names_before_key, prefix_to_key, key_name, names_after_key, suffix_to_key FROM author WHERE names_before_key = ? AND prefix_to_key IS NULL AND key_name = ? AND names_after_key = ? AND suffix_to_key = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $keyName, $namesAfterKey, $suffixToKey))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($namesAfterKey)){
            $stmt = $this->connect()->prepare('SELECT names_before_key, prefix_to_key, key_name, names_after_key, suffix_to_key FROM author WHERE names_before_key = ? AND prefix_to_key = ? AND key_name = ? AND names_after_key IS NULL AND suffix_to_key = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $prefixToKey, $keyName, $suffixToKey))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else if(is_null($suffixToKey)){
            $stmt = $this->connect()->prepare('SELECT names_before_key, prefix_to_key, key_name, names_after_key, suffix_to_key FROM author WHERE names_before_key = ? AND prefix_to_key = ? AND key_name = ? AND names_after_key = ? AND suffix_to_key IS NULL;');
            if(!$stmt->execute(array($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        else {
            $stmt = $this->connect()->prepare('SELECT names_before_key, prefix_to_key, key_name, names_after_key, suffix_to_key FROM author WHERE names_before_key = ? AND prefix_to_key = ? AND key_name = ? AND names_after_key = ? AND suffix_to_key = ?;');
            if(!$stmt->execute(array($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey, $suffixToKey))) {
                $stmt = null;
                echo '<div class="wrapper"><p>stmt failed</p></div>';
                exit();
            }
        }

        if($stmt->rowCount() > 0)
            return false;
        return true;
    }

    protected function setAuthor($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey, $suffixToKey) {
        $stmt = $this->connect()->prepare('INSERT INTO author(names_before_key, prefix_to_key, key_name, names_after_key, suffix_to_key) VALUES(?, ?, ?, ?, ?);');

        if(!$stmt->execute(array($namesBeforeKey, $prefixToKey, $keyName, $namesAfterKey, $suffixToKey,))) {
            $stmt = null;
            echo '<div class="wrapper"><p>stmt failed</p></div>';
            exit();
        }
        
        $stmt = null;
    }
}