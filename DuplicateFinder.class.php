<?php

/**
 * Class DuplicateFinder
 *
 * DuplicateFinder tries to find duplicates of images by calling several different finder-objects
 * which do the real work. This is just a controller putting everything together.
 *
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
 */
class DuplicateFinder
{
    /**
     * @var array
     */
    private $finder = [];
    /**
     * @var Duplicates|null
     */
    private $duplicates = null;

    /**
     * DuplicateFinder constructor.
     */
    public function __construct()
    {
        $this->duplicates = Duplicates::getInstance();
    }

    /**
     * @param Finder $finder
     */
    public function injectFinder(Finder $finder)
    {
        $finder->injectDuplicates($this->duplicates);
        $this->finder[] = $finder;
    }

    /**
     * @param $path
     */
    public function searchDuplicates($path)
    {
        if ($handle = opendir($path)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry == "." || $entry == "..")
                    continue;
                $file = $path . '/' . $entry;

                if (is_dir($file)) {
                    $this->searchDuplicates($file);
                } else {
                    if (!strstr(mime_content_type($file), 'image/'))
                        continue;

                    foreach ($this->finder as $finder) {
//                        $start = microtime(true);
                        $finder->searchDuplicates($file);
//                        $end = microtime(true);
//                        $diff = round($end - $start, 4);
//                        echo $finder->getName() . ' took ' . $diff . 's' . "\n";
                    }
//                    echo "\n";
                }
            }
            closedir($handle);
        }
    }

    /**
     * @return Duplicates|null
     */
    public function getDuplicates()
    {
        return $this->duplicates;
    }
}