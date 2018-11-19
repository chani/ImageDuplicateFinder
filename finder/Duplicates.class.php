<?php

/**
 * Class Duplicates
 *
 * Just a simple singleton container which contains the logic to
 * normalize/de-duplicate the duplicate-arrays returned by all
 * the finders.
 *
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
 */
final class Duplicates
{
    /**
     * @var null
     */
    public static $instance = null;
    /**
     * @var array
     */
    private $duplicates = [];

    private function __construct()
    {
    }

    /**
     * @return Duplicates|null
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @todo optimize me
     * @param string $file
     * @param string $duplicateFile
     */
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
            // yes, the runtime will increase with every added duplicate. But I didn't find a nicer way
            // to do this, yet.
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

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->duplicates;
    }

    private function __clone()
    {
    }
}
