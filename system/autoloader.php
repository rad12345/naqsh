<?php

spl_autoload_register(function	($Class)	{
          //	project-specific	namespace	prefix
        $prefix	=	'rad';
          // Cut Root-Namespace
        $Class = str_replace( $prefix.'\\', '', $Class );
         // Correct DIRECTORY_SEPARATOR
        $Class = str_replace( array( '\\', '/' ), DIRECTORY_SEPARATOR, $Class.'.php' );
        // Get file real path
       if( false === ( $Class = realpath( $Class ) ) ) {
          // File not found
          return false;
        } else {
          require_once( $Class );
          return true;
       }
				});


?>