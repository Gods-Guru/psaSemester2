<?php
// Admin logout placeholder
session_start();
session_destroy();
header('Location: login.php');
exit;
