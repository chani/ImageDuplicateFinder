<?php

namespace Image\DuplicateFinder;

use Image\DuplicateFinder\finder\Finder;

/**
 * Class DuplicateRemover
 * @package Image\DuplicateFinder
 */
class DuplicateFinder
{
    /**
     * @var string
     */
    private $workingDir = '';
    /**
     * @var string
     */
    private $duplicateDir = '';
    /**
     * @var array
     */
    private $finders = [];
    /**
     * @var array
     */
    private $duplicates = [];
    /**
     * @var array
     */
    private $hashes = [];

    public function moveDuplicates()
    {
        if (count($this->duplicates) <= 0) {
            $this->getDuplicates();
        }

        // foreach ($this->duplicates as $duplicate) {
        //
        // }
    }

    /**
     * @return array
     */
    public function getDuplicates()
    {
        if (count($this->duplicates) <= 0) {
            $this->searchDuplicates($this->workingDir);
        }

        return $this->duplicates;
    }

    /**
     * @param $path
     */
    private function searchDuplicates($path)
    {
        if ($handle = opendir($path)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry == "." || $entry == "..") {
                    continue;
                }
                $file = $path . '/' . $entry;

                if (is_dir($file)) {
                    $this->searchDuplicates($file);
                } else {
                    if (!strstr(mime_content_type($file), 'image/')) {
                        continue;
                    }

                    /**
                     * @todo update reference image if copy is better
                     */
                    foreach ($this->finders as $finder) {
                        $finderName = $finder->getName();
                        $hash = $finder->getHash($file);
                        if (isset($this->hashes[$finderName][$hash])) {
                            $reference = $this->hashes[$finderName][$hash];
                            $this->duplicates[$reference][] = $file;
                            break;
                        }
                        $this->hashes[$finderName][$hash] = $file;
                    }
                }
            }
            closedir($handle);
        }
    }

    /**
     * @param Finder $finder
     */
    public function injectFinder(Finder $finder)
    {
        $this->finders[] = $finder;
    }

    /**
     * @return string
     */
    public function getWorkingDir()
    {
        return $this->workingDir;
    }

    /**
     * @param $workingDir
     */
    public function setWorkingDir($workingDir): void
    {
        $this->workingDir = $workingDir;
    }

    /**
     * @return string
     */
    public function getDuplicateDir()
    {
        return $this->duplicateDir;
    }

    /**
     * @param $duplicateDir
     */
    public function setDuplicateDir($duplicateDir): void
    {
        $this->duplicateDir = $duplicateDir;
    }
}