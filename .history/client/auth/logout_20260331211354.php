<?php
session_start();
require_once dirname(__DIR__) . "/../config/constants.php";

session_destroy();
header("Location: " . BASE_URL . "client/index.php");
exit;
