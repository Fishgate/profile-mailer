<?php
$image = imagecreatetruecolor(100, 100);

imagefilledrectangle($image, 0, 0, 100, 100, 0xFF0000);

header( 'Content-type: image/gif' );

imagegif($image);

?>
