<?php

$db = mysqli_connect("localhost", "root", "", "login_registration");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
