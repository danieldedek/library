<?php

class AllUsersContr extends AllUsers {

    private $order;
    private $sort;

    public function __construct($order, $sort) {
        $this->order = $order;
        $this->sort = $sort;
    }

    public function showAllUsers() {
        $this->getAllUsers($this->order, $this->sort);
    }
}
?>