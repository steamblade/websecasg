<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-type: image/png');

$length = 6; // Number of digits in the CAPTCHA
$width = 120; // Image width
$height = 40; // Image height

$text = generateRandomString($length);
$_SESSION['captcha'] = $text;

$image = imagecreatetruecolor($width, $height);
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
$noise_color = imagecolorallocate($image, 128, 128, 128);

imagefill($image, 0, 0, $background_color);

// Add noise dots
for ($i = 0; $i < ($width * $height) / 3; $i++) {
    imagesetpixel($image, rand(0, $width - 1), rand(0, $height - 1), $noise_color);
}

// Add random lines
for ($i = 0; $i < 5; $i++) {
    imageline($image, rand(0, $width - 1), rand(0, $height - 1), rand(0, $width - 1), rand(0, $height - 1), $noise_color);
}

$font = 'arial.ttf'; // Path to the TrueType font file
$font_size = 20;

// Calculate the position to center the text
$text_box = imagettfbbox($font_size, 0, $font, $text);
$text_width = abs($text_box[2] - $text_box[0]);
$text_height = abs($text_box[5] - $text_box[3]);
$text_x = ($width - $text_width) / 2;
$text_y = ($height - $text_height) / 2 + $text_height;

imagettftext($image, $font_size, 0, $text_x, $text_y, $text_color, $font, $text);

imagepng($image);
imagedestroy($image);

function generateRandomString($length) {
    $characters = '23456789abcdefghjkmnpqrstuvwxyz'; // Exclude confusing characters like 0, 1, i, l, o
    $characters_length = strlen($characters);
    $random_string = '';
    
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, $characters_length - 1)];
    }
    
    return $random_string;
}
?>
