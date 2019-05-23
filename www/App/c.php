<?php
header("X-XSS-Protection: 0");
echo $_GET["message"];
?>
