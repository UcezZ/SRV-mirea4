<?php
class QuickSort
{
    public static function sort(array &$array, int $low = -1, int $high = -1)
    {
        if ($low == -1) {
            $low = 0;
        }

        if ($high == -1) {
            $high = sizeof($array) - 1;
        }

        if (sizeof($array) == 0)
            return;

        if ($low >= $high)
            return;

        $o = $array[$low + ($high - $low) / 2];

        $i = $low;
        $j = $high;
        while ($i <= $j) {
            while ($array[$i] < $o)
                $i++;

            while ($array[$j] > $o)
                $j--;

            if ($i <= $j) {
                $t = $array[$i];
                $array[$i] = $array[$j];
                $array[$j] = $t;
                $i++;
                $j--;
            }
        }

        if ($low < $j) {
            QuickSort::sort($array, $low, $j);
        }

        if ($high > $i) {
            QuickSort::sort($array, $i, $high);
        }
    }
}
