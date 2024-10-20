<?php

$conn = mysqli_connect("localhost", "root", "", "vitoproject");

if (!$conn) {
  die ("Unable to connect! ". mysqli_connect_error());
}

?>