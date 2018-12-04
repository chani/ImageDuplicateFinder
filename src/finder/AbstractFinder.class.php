<?php

namespace Image\DuplicateFinder\finder;

/**
 * Class GenericFinder
 *
 * abstract class which holds stuff all concrete classes use.
 *
 * @author Jean-Michel Bruenn <himself@jeanbruenn.info>
 * @copyright 2018 <himself@jeanbruenn.info>
 * @license https://opensource.org/licenses/MIT The MIT License
 */
abstract class AbstractFinder
{
    /**
     * @return string
     */
    public function getName()
    {
        return get_class($this);
    }
}