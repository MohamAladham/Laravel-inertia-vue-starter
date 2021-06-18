<?php

/*
 *
 */
function get_setting( $key, $default = '' )
{
    return app( 'settings' )[$key] ?? $default;
}

