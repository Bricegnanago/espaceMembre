<?php
    require 'partials/functions.php'; 
    logged_only();
?>


<?php require 'partials/header.php';?>


<h1>Bonjour <?php echo $_SESSION['auth']->username;?></h1>

<?php require 'partials/footer.php';?> 