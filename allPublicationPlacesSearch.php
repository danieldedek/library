<?php
ob_start();
include "./header.php";
?>
<div class="wrapper">
    <div class="title">
        Všechna místa vydání - vyhledávání
    </div>
    <?php
    if(isset($_SESSION['user'])) {
    ?>
        <input type="text" id="search" placeholder="Místo vydání">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){
            $("#search").keypress(function(){
                $.ajax({
                    type:'POST',
                    url:'../includes/allPublicationPlacesSearch.inc.php',
                    data:{
                        publicationPlace:$("#search").val(),
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
        include "./classes/allPublicationPlacesSearch.classes.php";
        include "./classes/allPublicationPlacesSearch-contr.classes.php";
  
        $showAllPublicationPlaces = new AllPublicationPlacesSearchContr('');
        $showAllPublicationPlaces->showAllPublicationPlacesHelp();
    }
    else
        echo "<p>Pro zobrazení obsahu této stránky se musíte přihlásit</p>";
        ?>
</div>
<?php
include "./footer.php";
ob_end_flush();
?>