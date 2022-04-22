<?php
ob_start();
include "./header.php";
?>
<div class="wrapper">
    <div class="title">
        Všechna mezinárodní desetinná třídění - vyhledávání
    </div>
    <?php
    if(isset($_SESSION['user'])) {
    ?>
        <input type="text" id="search" placeholder="Mezinárodní desetinné třídění">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){
            $("#search").keypress(function(){
                $.ajax({
                    type:'POST',
                    url:'../includes/allUDCsSearch.inc.php',
                    data:{
                        UDC:$("#search").val(),
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
        include "./classes/allUDCsSearch.classes.php";
        include "./classes/allUDCsSearch-contr.classes.php";
  
        $showAllUDCs = new AllUDCsSearchContr('');
        $showAllUDCs->showAllUDCsHelp();
    }
    else
        echo "<p>Pro zobrazení obsahu této stránky se musíte přihlásit</p>";
        ?>
</div>
<?php
include "./footer.php";
ob_end_flush();
?>