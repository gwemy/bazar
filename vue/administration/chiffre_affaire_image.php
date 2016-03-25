<?php

session_start();
header("Content-type: image/png");

$gains = $_SESSION['gains'];
$max   = $_SESSION['max'];
$step  = 80;

$hauteur_bas   = 20;
$hauteur_haut  = 20;
$largeur_barre = 20;

$hauteur_image = 400;
$largeur_image = sizeof($gains) * ($largeur_barre + $step);


$image = imagecreate($largeur_image, $hauteur_image);

$blanc     = imagecolorallocate($image, 255, 255, 255);
$orange    = imagecolorallocate($image, 255, 128, 0);
$bleu      = imagecolorallocate($image, 0, 0, 255);
$bleuclair = imagecolorallocate($image, 156, 227, 254);
$noir      = imagecolorallocate($image, 0, 0, 0);
$rouge     = imagecolorallocate($image, 255, 0, 0);

imageLine($image, 0, ($hauteur_image - 20), ($largeur_image - 1), ($hauteur_image - $hauteur_bas), $noir);
//imagecolortransparent($image, $orange);
$font = '../polices/roboto-condensed-webfont.ttf';
//imagettftext($image, 20, 0, 10, 30, $noir, $font, "Chiffre d'affaire");

/*
 * imageline ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
 * imagefilledrectangle ( resource $image , int $x1 , int $y1 , int $x2 , int $y2 , int $color )
 * 1 = haut-gauche    2 = bas-droite
 * imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text 
 */


$i = 30;
foreach ($gains as $jour) {
    $somme = $jour['gain_somme'];
    $date  = $jour['gain_date'];
    $y1    = (($hauteur_image - $hauteur_bas ) - (($somme * ($hauteur_image - $hauteur_bas - $hauteur_haut)) / $max));

    imagefilledrectangle($image, $i, $y1, ($i + $largeur_barre), ($hauteur_image - $hauteur_bas - 1), $bleu);
    //imageSetPixel($image, $i, $y1, $rouge);
    imagettftext($image, 10, 0, ($i - 20), ($hauteur_image - 5), $noir, $font, $date);
    imagettftext($image, 10, 0, ($i - 20), ($y1 - 5), $noir, $font, number_format($somme, 2));
    $_SESSION['y1'][$i] = $y1;
    $i += $largeur_barre + $step;

    if ($i > $largeur_image + $largeur_barre - $step) {
        break;
    }
}

imagepng($image);
