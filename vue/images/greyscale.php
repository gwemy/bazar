<?php

header('Content-Type: image/png');

$image = imagecreatefrompng(filter_input(INPUT_GET, 'image', FILTER_SANITIZE_STRING));
imagefilter($image, IMG_FILTER_GRAYSCALE);
imagesavealpha($image, true);

imagepng($image);
