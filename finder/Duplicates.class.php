<?php

/**
 * Class Duplicates
 *
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
 */
final class Duplicates
{
    public static $instance = null;
    private $duplicates = [];

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function add($file, $duplicateFile)
    {
        $found = false;
        if(isset($this->duplicates[$file])){
            if (!in_array($duplicateFile, $this->duplicates[$file])) {
                $this->duplicates[$file][] = $duplicateFile;
            }
            $found = true;
        } elseif(isset($this->duplicates[$duplicateFile])){
            if (!in_array($file, $this->duplicates[$duplicateFile])) {
                $this->duplicates[$duplicateFile][] = $file;
            }
            $found = true;
        } else {
            foreach($this->duplicates as $key => $duplicates){
                if(in_array($file, $duplicates)){
                    $this->duplicates[$key][] = $duplicateFile;
                    $this->duplicates[$key] = array_unique($this->duplicates[$key]);
                    $found = true;
                    break;
                } elseif(in_array($duplicateFile, $duplicates)){
                    $this->duplicates[$key][] = $file;
                    $this->duplicates[$key] = array_unique($this->duplicates[$key]);
                    $found = true;
                    break;
                }
            }
        }
        if ($found != true) {
            $this->duplicates[$file][] = $duplicateFile;
            $this->duplicates[$file][] = $file;
        }
    }

    public function get($key)
    {
        return $this->duplicates[$key];
    }

    public function getAll()
    {
        return $this->duplicates;
    }

    private function __clone()
    {
    }
}
