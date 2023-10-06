<?php
session_start();
if(!isset($_SESSION['senha'])){
    header("Location: /api/index.php");
}
