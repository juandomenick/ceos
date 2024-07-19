<?php

use Illuminate\Contracts\Foundation\Application;

function providerRegister(string $path, string $namespace, Application $app) {
    $basePath = base_path() . '/' . $path;

    foreach (scandir($basePath) as $dir) {
        if ($dir != '.' && $dir != '..' && is_dir("{$basePath}/{$dir}")) {
            foreach (scandir("{$basePath}/{$dir}") as $subdir) {
                if (is_file("{$basePath}/{$dir}/${subdir}")) {
                    $fileName = pathinfo($subdir, PATHINFO_FILENAME);
                    $app->bind("{$namespace}\\$dir\\Interfaces\\{$fileName}Interface", "{$namespace}\\$dir\\$fileName");
                }
            }
        }
    }
}

