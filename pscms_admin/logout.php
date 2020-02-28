<?php 
require('session.inc');
unset($_SESSION['log']);
session_destroy(); 
?>
<script>parent.location.replace('index.php');</script>
