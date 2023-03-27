<?php
include "resources/functions/databaseDAO.php";

// Initialize the session
session_start();

// adatbázis kapcsolat létesítése
$conn = dbConnect();
