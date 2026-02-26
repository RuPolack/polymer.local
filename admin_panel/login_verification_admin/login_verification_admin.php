<?php
    if ($_SESSION['admin_id'] == null || 
        $_SESSION['admin_name'] == null || 
        $_SESSION['admin_password'] == null || 
        $_SESSION['created_at'] == null)
    {
        echo"Вы не вошли в акаунт";
        header('Location: ../admin_panel/login_admin.php');
    }
?>