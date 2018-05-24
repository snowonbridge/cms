<?php
$handle = fopen("file.txt","r+");
while ( ($c= fgetcsv($handle) ) !==false)
{
    var_export($c);

}
?>