<?php

namespace PicoDb;

use Exception;

/**
 * SQLException
 *
 * @author   Frederic Guillot
 */
class SQLException extends Exception
{

  public function __construct($message = null, $code = 0)
    {
        if (!$message) {
            throw new $this('Unknown '. get_class($this));
        }
        die(  $message ."  ".  $code);
    }

}
