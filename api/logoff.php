<?php
session_start();
session_destroy();


header("location: /api/index.php");
?>