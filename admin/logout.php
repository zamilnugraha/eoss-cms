<?php 
    session_start();
    
    session_destroy();
    
    // mengalihkan halaman sambil mengirim pesan logout
    header("location:../index.php?pesan=logout");
?>