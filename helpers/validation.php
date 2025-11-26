<?php
function antiinjection($conn, $data)
{
    $filter_sql = pg_escape_string(
        $conn,
        stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES)))
    );
    return $filter_sql;
}
?>
