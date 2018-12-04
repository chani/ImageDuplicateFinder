<?php

namespace Image\DuplicateFinder\finder;

/**
 * Class FileChecksum
 *
 * Simple sha1 checksum on the file contents to find duplicates
 *
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
 */
class FileChecksum extends AbstractFinder implements Finder
{
    /**
     * @var array
     */
    private $hashes = [];

    /**
     * @param $file
     *
     * @return bool
     */
    public function getHash($file)
    {
        $hash = sha1_file($file);
        $this->hashes[$hash] = $file;
        return $hash;
    }
}