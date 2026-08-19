<?php
$srcFile = __DIR__ . '/public/images/logo1.png'; // Let's use logo1.png as source if it exists, or just read the current logo.png
if (!file_exists($srcFile)) {
    $srcFile = __DIR__ . '/public/images/logo.png';
}
$destFile = __DIR__ . '/public/images/logo.png';
$faviconFile = __DIR__ . '/public/favicon.ico';

$img = @imagecreatefrompng($srcFile);
if (!$img) $img = @imagecreatefromjpeg($srcFile);

if (!$img) die("Could not load image");

$w = imagesx($img);
$h = imagesy($img);

$newImg = imagecreatetruecolor($w, $h);
// VERY IMPORTANT FOR TRANSPARENCY
imagealphablending($newImg, false);
imagesavealpha($newImg, true);

$transparent = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
imagefill($newImg, 0, 0, $transparent);

$cx = $w / 2;
$cy = $h / 2;
$r = min($cx, $cy) - 2; // slight padding

for ($x = 0; $x < $w; $x++) {
    for ($y = 0; $y < $h; $y++) {
        $dx = $x - $cx;
        $dy = $y - $cy;
        $dist = sqrt($dx*$dx + $dy*$dy);
        
        if ($dist <= $r) {
            $color = imagecolorat($img, $x, $y);
            imagesetpixel($newImg, $x, $y, $color);
        } else if ($dist <= $r + 1) {
            // Anti-aliasing edge
            $color = imagecolorat($img, $x, $y);
            $colors = imagecolorsforindex($img, $color);
            $alpha = 127 * ($dist - $r);
            if ($alpha > 127) $alpha = 127;
            $newColor = imagecolorallocatealpha($newImg, $colors['red'], $colors['green'], $colors['blue'], (int)$alpha);
            imagesetpixel($newImg, $x, $y, $newColor);
        }
    }
}

imagepng($newImg, $destFile);
imagepng($newImg, $faviconFile);
echo "Logo fixed and saved!";
