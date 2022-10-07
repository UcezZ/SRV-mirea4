<?php

class Figure
{
    private $type, $width, $height, $color;

    public function __construct(int $arg)
    {
        $this->width = $arg & 0xFF;
        $this->height = ($arg >> 8) & 0xFF;
        $this->type = ($arg >> 16) & 0x1;
        $this->color = ($arg >> 17) & 0x7;
    }

    public function getTypeString()
    {
        switch ($this->type) {
            case 0:
                return 'Circle';
            case 1:
                return 'Rectangle';
            default:
                return 'Undefined';
        }
    }

    public function getColorHEX()
    {
        switch ($this->color) {
            case 0:
                return '#F00';
            case 1:
                return '#0F0';
            case 2:
                return '#00F';
            case 3:
                return '#FF0';
            case 4:
                return '#F0F';
            case 5:
                return '#0FF';
            case 6:
                return '#888';
            case 7:
                return '#000';
        }
    }

    public function printInfo()
    {
        print("<p>Width: {$this->width}<br>Height: {$this->height}<br>Type: {$this->getTypeString()}<br>Color: {$this->getColorHEX()}<br></p>");
    }

    public function draw()
    {
        switch ($this->type) {
            case 0:
                $x = $this->width / 2;
                $y = ($this->height == 0 ? $this->width : $this->height) / 2;
                return '<svg width="' . $this->width . '" height="' . ($y * 2) . '"><ellipse cx="' . $x  . '" cy="' . $y . '" rx="' . $x .
                    '" ry="' . $y . '" stroke="black" fill="' . $this->getColorHEX() . '" stroke-width="0"/></svg>';
                break;
            case 1:
                return '<svg width="' . $this->width . '" height="' . ($this->height == 0 ? $this->width : $this->height) . '"><rect x="0" y="0" width="' .
                    $this->width . '" height="' . $this->height . '" stroke="black" fill="' . $this->getColorHEX() . '" stroke-width="0"/></svg>';
                break;
        }

        return 'Figure error';
    }
}
