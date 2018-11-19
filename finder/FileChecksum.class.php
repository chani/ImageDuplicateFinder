<?php

/**
 * Class FileChecksum
 *
 * Simple sha1 checksum on the file contents to find duplicates
 *
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
 */
class FileChecksum extends GenericFinder implements Finder
{
    /**
     * @var array
     */
    private $hashes = [];

    /**
     * @param string $file
     */
    public function searchDuplicates($file)
    {
        $hash = sha1_file($file);
        if (isset($this->hashes[$hash])) {
            $this->duplicates->add($file, $this->hashes[$hash]);
        }

        $this->hashes[$hash] = $file;
    }
}