<?php
namespace Image\DuplicateFinder\finder;
/**
 * Interface FinderInterface
 *
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
 */
interface Finder
{
    /**
     * @param $file
     *
     * @return string
     */
    public function getHash($file);
}