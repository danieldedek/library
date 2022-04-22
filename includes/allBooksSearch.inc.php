<?php

if((isset($_POST['book'])) && (isset($_POST['ISBN'])) && (isset($_POST['incrementalNumber'])) && (isset($_POST['UDC']))) {
    $book = htmlspecialchars($_POST['book']);
    $ISBN = htmlspecialchars($_POST['ISBN']);
    $incrementalNumber = htmlspecialchars($_POST['incrementalNumber']);
    $UDC = htmlspecialchars($_POST['UDC']);

    include "../classes/dbh.classes.php";
    include "../classes/allBooksSearch.classes.php";
    include "../classes/allBooksSearch-contr.classes.php";

    $showAllBooks = new AllBooksSearchContr($book, $ISBN, $incrementalNumber, $UDC);

    $showAllBooks->showAllBooks();
}

elseif((isset($_POST['book'])) && (isset($_POST['ISBN'])) && (isset($_POST['incrementalNumber']))) {
    $book = htmlspecialchars($_POST['book']);
    $ISBN = htmlspecialchars($_POST['ISBN']);
    $incrementalNumber = htmlspecialchars($_POST['incrementalNumber']);
    $UDC = '';

    include "../classes/dbh.classes.php";
    include "../classes/allBooksSearch.classes.php";
    include "../classes/allBooksSearch-contr.classes.php";

    $showAllBooks = new AllBooksSearchContr($book, $ISBN, $incrementalNumber, $UDC);

    $showAllBooks->showAllBooks();
}

elseif((isset($_POST['book'])) && (isset($_POST['ISBN'])) && (isset($_POST['UDC']))) {
    $book = htmlspecialchars($_POST['book']);
    $ISBN = htmlspecialchars($_POST['ISBN']);
    $incrementalNumber = '';
    $UDC = htmlspecialchars($_POST['UDC']);

    include "../classes/dbh.classes.php";
    include "../classes/allBooksSearch.classes.php";
    include "../classes/allBooksSearch-contr.classes.php";

    $showAllBooks = new AllBooksSearchContr($book, $ISBN, $incrementalNumber, $UDC);

    $showAllBooks->showAllBooks();
}

elseif((isset($_POST['book'])) && (isset($_POST['incrementalNumber'])) && (isset($_POST['UDC']))) {
    $book = htmlspecialchars($_POST['book']);
    $ISBN = '';
    $incrementalNumber = htmlspecialchars($_POST['incrementalNumber']);
    $UDC = htmlspecialchars($_POST['UDC']);

    include "../classes/dbh.classes.php";
    include "../classes/allBooksSearch.classes.php";
    include "../classes/allBooksSearch-contr.classes.php";

    $showAllBooks = new AllBooksSearchContr($book, $ISBN, $incrementalNumber, $UDC);

    $showAllBooks->showAllBooks();
}

elseif((isset($_POST['ISBN'])) && (isset($_POST['incrementalNumber'])) && (isset($_POST['UDC']))) {
    $book = '';
    $ISBN = htmlspecialchars($_POST['ISBN']);
    $incrementalNumber = htmlspecialchars($_POST['incrementalNumber']);
    $UDC = htmlspecialchars($_POST['UDC']);

    include "../classes/dbh.classes.php";
    include "../classes/allBooksSearch.classes.php";
    include "../classes/allBooksSearch-contr.classes.php";

    $showAllBooks = new AllBooksSearchContr($book, $ISBN, $incrementalNumber, $UDC);

    $showAllBooks->showAllBooks();
}

elseif((isset($_POST['book'])) && (isset($_POST['ISBN']))) {
    $book = htmlspecialchars($_POST['book']);
    $ISBN = htmlspecialchars($_POST['ISBN']);
    $incrementalNumber = '';
    $UDC = '';

    include "../classes/dbh.classes.php";
    include "../classes/allBooksSearch.classes.php";
    include "../classes/allBooksSearch-contr.classes.php";

    $showAllBooks = new AllBooksSearchContr($book, $ISBN, $incrementalNumber, $UDC);

    $showAllBooks->showAllBooks();
}

elseif((isset($_POST['book'])) && (isset($_POST['incrementalNumber']))) {
    $book = htmlspecialchars($_POST['book']);
    $ISBN = '';
    $incrementalNumber = htmlspecialchars($_POST['incrementalNumber']);
    $UDC = '';

    include "../classes/dbh.classes.php";
    include "../classes/allBooksSearch.classes.php";
    include "../classes/allBooksSearch-contr.classes.php";

  $showAllBooks = new AllBooksSearchContr($book, $ISBN, $incrementalNumber, $UDC);

    $showAllBooks->showAllBooks();
}

elseif((isset($_POST['book'])) && (isset($_POST['UDC']))) {
    $book = htmlspecialchars($_POST['book']);
    $ISBN = '';
    $incrementalNumber = '';
    $UDC = htmlspecialchars($_POST['UDC']);

    include "../classes/dbh.classes.php";
    include "../classes/allBooksSearch.classes.php";
    include "../classes/allBooksSearch-contr.classes.php";

    $showAllBooks = new AllBooksSearchContr($book, $ISBN, $incrementalNumber, $UDC);

    $showAllBooks->showAllBooks();
}

elseif((isset($_POST['ISBN'])) && (isset($_POST['incrementalNumber']))) {
    $book = '';
    $ISBN = htmlspecialchars($_POST['ISBN']);
    $incrementalNumber = htmlspecialchars($_POST['incrementalNumber']);
    $UDC = '';

    include "../classes/dbh.classes.php";
    include "../classes/allBooksSearch.classes.php";
    include "../classes/allBooksSearch-contr.classes.php";

    $showAllBooks = new AllBooksSearchContr($book, $ISBN, $incrementalNumber, $UDC);

    $showAllBooks->showAllBooks();
}

elseif((isset($_POST['ISBN'])) && (isset($_POST['UDC']))) {
    $book = '';
    $ISBN = htmlspecialchars($_POST['ISBN']);
    $incrementalNumber = '';
    $UDC = htmlspecialchars($_POST['UDC']);

    include "../classes/dbh.classes.php";
    include "../classes/allBooksSearch.classes.php";
    include "../classes/allBooksSearch-contr.classes.php";

    $showAllBooks = new AllBooksSearchContr($book, $ISBN, $incrementalNumber, $UDC);

    $showAllBooks->showAllBooks();
}

elseif((isset($_POST['incrementalNumber'])) && (isset($_POST['UDC']))) {
    $book = '';
    $ISBN = '';
    $incrementalNumber = htmlspecialchars($_POST['incrementalNumber']);
    $UDC = htmlspecialchars($_POST['UDC']);

    include "../classes/dbh.classes.php";
    include "../classes/allBooksSearch.classes.php";
    include "../classes/allBooksSearch-contr.classes.php";

    $showAllBooks = new AllBooksSearchContr($book, $ISBN, $incrementalNumber, $UDC);

    $showAllBooks->showAllBooks();
}

elseif(isset($_POST['book'])) {
    $book = htmlspecialchars($_POST['book']);
    $ISBN = '';
    $incrementalNumber = '';
    $UDC = '';

    include "../classes/dbh.classes.php";
    include "../classes/allBooksSearch.classes.php";
    include "../classes/allBooksSearch-contr.classes.php";

    $showAllBooks = new AllBooksSearchContr($book, $ISBN, $incrementalNumber, $UDC);

    $showAllBooks->showAllBooks();
}

elseif(isset($_POST['ISBN'])) {
    $book = '';
    $ISBN = htmlspecialchars($_POST['ISBN']);
    $incrementalNumber = '';
    $UDC = '';

    include "../classes/dbh.classes.php";
    include "../classes/allBooksSearch.classes.php";
    include "../classes/allBooksSearch-contr.classes.php";

    $showAllBooks = new AllBooksSearchContr($book, $ISBN, $incrementalNumber, $UDC);

    $showAllBooks->showAllBooks();
}

elseif(isset($_POST['incrementalNumber'])) {
    $book = '';
    $ISBN = '';
    $incrementalNumber = htmlspecialchars($_POST['incrementalNumber']);
    $UDC = '';

    include "../classes/dbh.classes.php";
    include "../classes/allBooksSearch.classes.php";
    include "../classes/allBooksSearch-contr.classes.php";

    $showAllBooks = new AllBooksSearchContr($book, $ISBN, $incrementalNumber, $UDC);

    $showAllBooks->showAllBooks();
}

elseif(isset($_POST['UDC'])) {
    $book = '';
    $ISBN = '';
    $incrementalNumber = '';
    $UDC = htmlspecialchars($_POST['UDC']);

    include "../classes/dbh.classes.php";
    include "../classes/allBooksSearch.classes.php";
    include "../classes/allBooksSearch-contr.classes.php";

    $showAllBooks = new AllBooksSearchContr($book, $ISBN, $incrementalNumber, $UDC);

    $showAllBooks->showAllBooks();
}
?>