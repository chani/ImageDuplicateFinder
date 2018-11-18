<?php

/**
 * Class GenericFinder
 */
abstract class GenericFinder
{
    /**
     * @var Duplicates|null
     */
    protected $duplicates = null;

    /**
     * @param Duplicates $duplicates
     */
    public function injectDuplicates(Duplicates $duplicates)
    {
        $this->duplicates = $duplicates;
    }
}