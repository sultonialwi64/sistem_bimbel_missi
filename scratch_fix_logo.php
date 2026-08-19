<?php
$srcFile = __DIR__ . '/public/images/logo.png';
$destFile = __DIR__ . '/public/images/logo.png';
$faviconFile = __DIR__ . '/public/favicon.ico';

if (!file_exists($srcFile)) {
    die("Source file not found: $srcFile\n");
}

// Load the image (it might be a JPEG saved as PNG, or PNG with black background)
$img = @imagecreatefrompng($srcFile);
if (!$img) {
    $img = @imagecreatefromjpeg($srcFile);
}
if (!$img) {
    die("Failed to load image.\n");
}

$width = imagesx($img);
$height = imagesy($img);

// Create a new true color image with alpha channel
$newImg = imagecreatetruecolor($width, $height);
imagesavealpha($newImg, true);
$transparent = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
imagefill($newImg, 0, 0, $transparent);

// Calculate center and radius
$cx = $width / 2;
$cy = $height / 2;
$r = min($cx, $cy); // radius

for ($x = 0; $x < $width; $x++) {
    for ($y = 0; $y < $height; $y++) {
        $dx = $x - $cx;
        $dy = $y - $cy;
        // Anti-aliasing (basic)
        $distance = sqrt($dx * $dx + $dy * $dy);
        
        if ($distance <= $r) {
            $color = imagecolorat($img, $x, $y);
            // If the edge is rough, we can apply anti-aliasing, but for now simple circle
            imagesetpixel($newImg, $x, $y, $color);
        } else if ($distance <= $r + 1) {
            // Soft edge
            $color = imagecolorat($img, $x, $y);
            $colors = imagecolorsforindex($img, $color);
            $alpha = 127 * ($distance - $r);
            if ($alpha > 127) $alpha = 127;
            $newColor = imagecolorallocatealpha($newImg, $colors['red'], $colors['green'], $colors['blue'], $alpha);
            imagesetpixel($newImg, $x, $y, $newColor);
        }
    }
}

// Save the new image
imagepng($newImg, $destFile);
imagepng($newImg, $faviconFile); // Also overwrite favicon.ico

imagedestroy($img);
imagedestroy($newImg);

echo "Logo processed successfully.\n";
