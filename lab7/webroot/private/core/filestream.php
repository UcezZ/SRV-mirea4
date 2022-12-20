<?php

class FileStream
{
    private string $path, $mime;
    private mixed $stream;
    private int $buffer = 262144, $start, $end, $size;

    function __construct(string $filePath, ?string $mime)
    {
        $this->path = $filePath;
        $this->mime = $mime ?? 'application/octet-stream';
    }

    private function open()
    {
        if (!($this->stream = fopen($this->path, 'rb'))) {
            die('Could not open stream for reading');
        }
    }

    private function setHeader(string|null $downloadName = null)
    {
        if (ob_get_level()) {
            ob_end_clean();
        }
        header('Content-Type: ' . $this->mime);
        if (!is_null($downloadName)) {
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename="' . $downloadName . '"');
        }
        $this->start = 0;
        $this->size = filesize($this->path);
        $this->end = $this->size - 1;
        header("Accept-Ranges: bytes");

        if (isset($_SERVER['HTTP_RANGE'])) {

            $c_start = $this->start;
            $c_end = $this->end;

            list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
            if (strpos($range, ',') !== false) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header('Content-Range: bytes ' . $this->start . '-' . $this->end . '/' . $this->size);
                return;
            }
            if ($range == '-') {
                $c_start = $this->size - substr($range, 1);
            } else {
                $range = explode('-', $range);
                $c_start = $range[0];

                $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $c_end;
            }
            $c_end = ($c_end > $this->end) ? $this->end : $c_end;
            if ($c_start > $c_end || $c_start > $this->size - 1 || $c_end >= $this->size) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header('Content-Range: bytes ' . $this->start . '-' . $this->end . '/' . $this->size);
                return;
            }
            $this->start = $c_start;
            $this->end = $c_end;
            $length = $this->end - $this->start + 1;
            fseek($this->stream, $this->start);
            header('HTTP/1.1 206 Partial Content');
            header('Content-Length: ' . $length);
            header('Content-Range: bytes ' . $this->start . '-' . $this->end . '/' . $this->size);
        } else {
            header('Content-Length: ' . $this->size);
        }
    }

    private function end()
    {
        fclose($this->stream);
        exit;
    }

    private function stream()
    {
        $i = $this->start;
        set_time_limit(0);
        while (!feof($this->stream) && $i <= $this->end) {
            $bytesToRead = $this->buffer;
            if (($i + $bytesToRead) > $this->end) {
                $bytesToRead = $this->end - $i + 1;
            }
            $data = fread($this->stream, $bytesToRead);

            print($data);
            flush();

            $i += $bytesToRead;
        }
    }

    function send(string|null $downloadName = null)
    {
        $this->open();
        $this->setHeader($downloadName);
        $this->stream();
        $this->end();
    }
}
