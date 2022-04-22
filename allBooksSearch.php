<?php
ob_start();
include "./header.php";
?>
<div class="wrapper">
    <div class="title">
        Všechny knihy - vyhledávání
    </div>
    <?php
    if(isset($_SESSION['user'])) {
    ?>
        <input type="text" id="search" placeholder="Název knihy">
        <input type="text" id="search1" placeholder="ISBN">
        <input type="text" id="search2" placeholder="Přírůstkové číslo">
        <input type="text" id="search3" placeholder="Mezinárodní desetinné třídění">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){
            $("#search").keypress(function(){
                $.ajax({
                    type:'POST',
                    url:'../includes/allBooksSearch.inc.php',
                    data:{
                        book:$("#search").val(),
                        ISBN:$("#search1").val(),
                        incrementalNumber:$("#search2").val(),
                        UDC:$("#search3").val(),
                    },
                    success:function(data){
                        $("#output").html(data);
                    }
                });
            });
            $("#search1").keypress(function(){
                $.ajax({
                    type:'POST',
                    url:'../includes/allBooksSearch.inc.php',
                    data:{
                        book:$("#search").val(),
                        ISBN:$("#search1").val(),
                        incrementalNumber:$("#search2").val(),
                        UDC:$("#search3").val(),
                    },
                    success:function(data){
                        $("#output").html(data);
                    }
                });
            });
            $("#search2").keypress(function(){
                $.ajax({
                    type:'POST',
                    url:'../includes/allBooksSearch.inc.php',
                    data:{
                        book:$("#search").val(),
                        ISBN:$("#search1").val(),
                        incrementalNumber:$("#search2").val(),
                        UDC:$("#search3").val(),
                    },
                    success:function(data){
                        $("#output").html(data);
                    }
                });
            });
            $("#search3").keypress(function(){
                $.ajax({
                    type:'POST',
                    url:'../includes/allBooksSearch.inc.php',
                    data:{
                        book:$("#search").val(),
                        ISBN:$("#search1").val(),
                        incrementalNumber:$("#search2").val(),
                        UDC:$("#search3").val(),
                    },
                    success:function(data){
                        $("#output").html(data);
                    }
                });
            });
        });
        </script>
        <div id="output"></div>
        <?php
        include "./classes/dbh.classes.php";
        include "./classes/allBooksSearch.classes.php";
        include "./classes/allBooksSearch-contr.classes.php";
  
        $showAllBooks = new AllBooksSearchContr('', '', '', '');
        $showAllBooks->showAllBooksHelp();
    }
    else
        echo "<p>Pro zobrazení obsahu této stránky se musíte přihlásit</p>";
        ?>
</div>
<?php
include "./footer.php";
ob_end_flush();
?>