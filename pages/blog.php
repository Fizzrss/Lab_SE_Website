<?php
// Redirect blog.php to berita.php
header('Location: berita.php' . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
exit;
?>
