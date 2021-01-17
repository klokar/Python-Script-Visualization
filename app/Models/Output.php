<?php

namespace App\Models;

/**
 * @property string $message
 * @property string $level
 */
class Output
{
    public const DEBUG = 'D';
    public const SUCCESS = 'S';
    public const ERROR = 'E';

    public $message;
    public $level;

    public function __construct(string $message, $level = self::DEBUG)
    {
        $this->message = preg_replace('/\s+/', ' ', $message); // trim duplicate spaces
        $this->level = $level;
    }

    public static function decode(string $line): self
    {
        if (strpos($line, ':') === false) {
            return new Output($line);
        } else {
            return new Output(substr($line, 2), substr($line, 0, 1));
        }
    }

    public function write(): string
    {
        return sprintf('%s:%s', $this->level, $this->message);
    }
}
