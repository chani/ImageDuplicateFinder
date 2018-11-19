<?php

/**
 * Interface Finder
 *
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
 */
interface Finder
{
    /**
     * @param Duplicates $duplicates
     */
    public function injectDuplicates(Duplicates $duplicates);

    /**
     * @param $file
     */
    public function searchDuplicates($file);
}