<?php
$vConn = pg_connect("host=127.0.0.1 port=5432 dbname=dbnf17p044 user=nf17p044 password=AZ7aworu");
error_reporting(E_ALL ^ E_NOTICE);

// "Désactivation" des magic quotes
if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}
?>