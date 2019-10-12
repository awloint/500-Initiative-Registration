<?php
/**
 * This is the autoloader for the classes
 *
 * PHP version 7.2
 *
 * @category Autoloader
 * @package  Bootstrap_File
 * @author   Benson Imoh <benson@stbensonimoh.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://opensource.org/licenses/MIT
 */

spl_autoload_register(
    function ($className) {
        $file = dirname(__DIR__) . '\\scripts\\' . $className . '.php';
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
        if (file_exists($file)) {
            include $file;
        }
    }
);
