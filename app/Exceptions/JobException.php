<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\UseItem;
use Throwable;

class JobException extends Exception
{
    private $extras = [];
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null,$extras = [])
    {
        $this->extras = $extras;
        $this->message = $message;
    }
    public function report()
    {
        Log::channel('json_upload')->error($this->getMessage().' on '.$this->getFile().' in Line:'.$this->getLine(),$this->extras);
    }
}
