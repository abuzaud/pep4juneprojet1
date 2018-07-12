<?php
/**
 * Created by PhpStorm.
 * User: Antoine
 * Date: 11/07/2018
 * Time: 19:52
 */

namespace App\Controller\Logger;


use Psr\Log\AbstractLogger;

class FileLogger extends AbstractLogger
{
    private $folder;
    private $filename;

    public function __construct()
    {
        $this->folder = '..\var'.DIRECTORY_SEPARATOR.'log';
        $this->filename = 'workflow.log';
    }

    public function log($level, $message, array $context = array())
    {
        $message = '['.date('Y-m-d H:i:s').' ] ['.$level.'] : '.vsprintf($message, $context).PHP_EOL;
        file_put_contents($this->folder.DIRECTORY_SEPARATOR.$this->filename, $message, LOCK_EX | FILE_APPEND);
    }
}