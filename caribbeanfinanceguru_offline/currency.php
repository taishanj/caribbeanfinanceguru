<?php
$original = ["Over","%"];
$new = ["",""];
$string = "Over 10%";
echo str_replace("Over","",$string);
echo "New line";
echo trim(str_replace($original,$new,$string));
?>
