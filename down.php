<?php
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename('./chatlog.txt'));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize('./chatlog.txt'));
    readfile('./chatlog.txt');
    exit;
?>