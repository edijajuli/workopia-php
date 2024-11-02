<?php

/**
 * Get the base path
 * 
 * @param string $path
 * @return string
 */
function basePath($path = '')
{
    return __DIR__ . '/' . $path;
}

/**
 * Load a view
 * 
 * @param string $name
 * @return void
 */
function loadView($name)
{
    $viewPath = basePath("views/{$name}.view.php");

    if (file_exists($viewPath)) {
        require $viewPath;
    } else {
        echo "View `{$name} not found`";
    }
}

/**
 * Load a partials
 * 
 * @param string $name
 * @return void
 */
function loadPartials($name)
{
    $partialsPath = basePath("views/partials/{$name}.php");

    if (file_exists($partialsPath)) {
        require $partialsPath;
    } else {
        echo "View `{$name} not found`";
    }
}
