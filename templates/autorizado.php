<?php
    if( !isset($_SESSION['admin']) || $_SESSION['admin'] == 0 ){
        header('Location: /index.php?logout=error');
    }
?>


    
