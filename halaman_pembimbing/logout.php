<?php
session_start();

session_destroy();
session_unset();

header('Location: ../2)halaman_login/halaman_login.php');