<?php

// LOG OUT

session_start();
session_destroy();

header("Location:/");

?>