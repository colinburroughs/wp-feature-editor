<?php
/**
 * Dynamically loads the classes attempting to be instantiated elsewhere in the plugin.
 */

use Hobo\Framework\Autoloader;

class Feature_Editor_Plugin_Autoloader extends Autoloader
{
    public function __construct()
    {
        parent::__construct(__FILE__, 'Feature_Editor');
    }
}
