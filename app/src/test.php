<?php
$myPDO = new PDO('pgsql:host=pipelinedb;dbname=postgres', 'postgres', '');
var_dump($myPDO);


$result = $myPDO->query("CREATE FOREIGN TABLE stream (x integer, y integer) SERVER pipelinedb;");
$result = $myPDO->query("CREATE VIEW v AS SELECT sum(x + y) FROM stream;");
$result = $myPDO->query("INSERT INTO stream (x, y) VALUES (5,7);");

$result = $myPDO->query("SELECT * FROM pipeline.views;");
var_dump($result);

$result = $myPDO->query("SELECT * FROM v;");
while ($row = $result->fetch())
{
    var_dump($row);
}
var_dump($result);

?>
