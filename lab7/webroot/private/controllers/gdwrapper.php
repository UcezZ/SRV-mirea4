<?php

class GDWrapper
{
    public static function drawLinear(int $parts, int $width, int $height, int $xpad = 0, int $ypad = 0)
    {
        $img = self::createImage($width, $height);

        $points = self::getRandomPoints($img, $parts, $width, $height, $xpad, $ypad);

        foreach ($points as $key => $point) {
            if ($key) {
                for ($x = -1; $x < 1; $x++) {
                    for ($y = -1; $y < 1; $y++) {
                        imageline($img, $points[$key - 1]['x'] + $x, $points[$key - 1]['y'] + $y, $point['x'] + $x, $point['y'] + $y, $points[$key - 1]['color']);
                    }
                }
            }
            imagefilledellipse($img, $point['x'], $point['y'], 9, 9, $point['color']);
        }
        self::drawWatermark($img);
        self::sendImage($img);
        return $points;
    }

    public static function drawCircular(int $parts, int $width, int $height, int $xpad = 0, int $ypad = 0)
    {
        $img = self::createImage($width, $height);

        $pieces = self::getRandomParts($img, $parts, $width, $height, $xpad, $ypad);

        $angle = 0;

        foreach ($pieces as $key => $piece) {
            imagefilledarc(
                $img,
                $width / 2,
                $height / 2,
                $width - $xpad * 2,
                $height - $ypad * 2,
                $angle,
                $key < sizeof($pieces) - 1 ? $angle += intval($piece['percent'] * 360) : 360,
                $piece['color'],
                IMG_ARC_PIE
            );
        }
        self::drawWatermark($img);
        self::sendImage($img);
        return $pieces;
    }

    public static function drawColumnar(int $parts, int $width, int $height, int $xpad = 0, int $ypad = 0)
    {
        $img = self::createImage($width, $height);

        $co = ($width) / ($parts * $parts);
        $cw = ($width) / $parts - $co;

        $pieces = self::getRandomParts($img, $parts, $width, $height, $xpad, $ypad);

        foreach ($pieces as $key => $piece) {
            imagefilledrectangle(
                $img,
                $key * ($cw + $co) + $co,
                $height - $ypad,
                ($key + 1) * ($cw + $co) - $co,
                $height - $ypad - $piece['percentmax'] * ($height - $ypad * 2),
                $piece['color']
            );
        }
        self::drawWatermark($img);
        self::sendImage($img);
        return $pieces;
    }

    private static function getRandomPoints(GdImage $image, int $partcount, int $width, int $height, int $xpad, int $ypad)
    {
        $points = [];
        for ($i = 0; $i <= $partcount; $i++) {
            array_push($points, [
                'x' => $xpad + intval(($i) / $partcount * ($width - $xpad * 2)),
                'y' => $ypad + rand(0, $height - $ypad * 2),
                'color' => self::getRandomColor($image)
            ]);
        }

        return $points;
    }

    private static function getRandomParts(GdImage $image, int $count)
    {
        $points = [];
        $total = 0;
        $max = 0;
        for ($i = 0; $i < $count; $i++) {
            array_push($points, [
                'value' => rand(0, 255),
                'count' => rand(64, 256),
                'color' => self::getRandomColor($image)
            ]);
            $total += $points[$i]['count'];
            if ($points[$i]['count'] > $max) {
                $max = $points[$i]['count'];
            }
        }
        for ($i = 0; $i < $count; $i++) {
            $points[$i]['percent'] = $points[$i]['count'] / $total;
            $points[$i]['percentmax'] = $points[$i]['count'] / $max;
        }
        return $points;
    }

    private static function getRandomColor(GdImage $image)
    {
        return imagecolorallocate($image, rand(0, 224), rand(0, 224), rand(0, 224));
    }

    private static function createImage(int $width, int $height)
    {
        $image = imagecreatetruecolor($width, $height);
        imagefill($image, 0, 0, imagecolorallocate($image, 255, 255, 255));
        return $image;
    }

    private static function sendImage(GdImage $image)
    {
        header('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    }
    private static function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
    {
        $cut = imagecreatetruecolor($src_w, $src_h);
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
    }

    private static function drawWatermark(GdImage $image)
    {
        $width = imagesx($image);
        $height = imagesy($image);

        $overlay = imagecreatefrompng(__DIR__ . '/../../media/watermark.png');
        $overlaywidth = imagesx($overlay);
        $overlayheight = imagesy($overlay);

        for ($i = 0; $i < $width; $i += $overlaywidth) {
            for ($j = 0; $j < $height; $j += $overlayheight) {
                self::imagecopymerge_alpha(
                    $image,
                    $overlay,
                    $i,
                    $j,
                    0,
                    0,
                    $overlaywidth,
                    $overlayheight,
                    25
                );
            }
        }
    }
}
