<?php

/**
 * Class DuplicateFinder
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
     * @param string $path
     */
    public function searchDuplicates($path)
    {
        foreach ($this->getFiles($path) as $file) {
            foreach ($this->finder as $finder) {
                $finder->searchDuplicates($file);
            }
        }
    }

    /**
     * @param $path
     * @return array
     */
    private function getFiles($path)
    {
        $files = array();
        if ($handle = opendir($path)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry == "." && $entry == "..")
                    continue;

                if (!strstr(mime_content_type($path . '/' . $entry), 'image/'))
                    continue;

                if (is_dir($path . '/' . $entry)) {
                    $files = array_merge($files, $this->getFiles($path . '/' . $entry));
                } else {
                    $files[] = $path . '/' . $entry;
                }

            }
            closedir($handle);
        }
        return $files;
    }

    /**
     * @return Duplicates|null
     */
    public function getDuplicates()
    {
        return $this->duplicates;
    }
}