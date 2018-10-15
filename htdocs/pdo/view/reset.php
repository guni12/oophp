<?php
// Restore the database to its original settings
$file   = "sql/setup.sql";
//$mysql  = "/usr/bin/mysql";
$mysql  = "c:/xampp/mysql/bin/mysql.exe";
//$mysql  = "c:/xampp/mysql/bin/mysqld.exe";
//$mysql  = "c:/xampp/mysql/bin/mysqldump.exe";
$output = null;

// Extract hostname and databasename from dsn
$dsnDetail = [];
preg_match("/mysql:host=(.+);port=([^;.]+);dbname=([^;.]+)/", $databaseConfig["dsn"], $dsnDetail);
var_dump($dsnDetail);
$host = $dsnDetail[1];
var_dump($host);
$port = $dsnDetail[2];
//$host = $host . ":" . $port;
$database = $dsnDetail[3];
$login = $databaseConfig["login"];
$password = $databaseConfig["password"];

//mysql --host=localhost --port=9999 mysql -u root -p --execute="show tables;"

if (isset($_POST["reset"]) || isset($_GET["reset"])) {
    //$command = "$mysql -h{$host} -u{$login} -p{$password} $database < $file 2>&1";
    $command = "$mysql --host={$host} --port={$port} -u{$login} -p{$password} $database < $file 2>&1";
    $output = [];
    $status = null;
    $res = exec($command, $output, $status);
    $output = "<p>The command was: <code>$command</code>.<br>The command exit status was $status."
        . "<br>The output from the command was:</p><pre>"
        . print_r($output, 1);
}

?>
<form method="post">
    <input type="submit" name="reset" value="Reset database">
    <?= $output ?>
</form>
