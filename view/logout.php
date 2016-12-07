<?php
session_destroy();
$url = 'index.php?page=home&success=' . " Sie haben sich erfolgreich abgemeldet";
header("Location: " . $url);
?>
