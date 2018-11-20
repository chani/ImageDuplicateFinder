<?php

/**
 * Class GenericFinder
 *
 * abstract class which holds stuff all concrete classes use.
 *
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
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

    /**
     * @return string
     */
    public function getName()
    {
        return get_class($this);
    }
}