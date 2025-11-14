<?php

declare(strict_types=1);

if (!function_exists('pipe')) {
    /**
     * Returns the result of executing a sequence of pipelined functions on a specific value.
     * Ej. `pipe('strtolower', 'ucwords', 'trim')('  jOHn dOE  ')` will returns 'John Doe'
     * 
     * @param array<Closure> $fns Functions list
     * @return mixed
     */
    function pipe(...$fns): mixed {
        return fn($initial_value) =>
        array_reduce($fns, function ($accumulator, $func) {
            return call_user_func($func, $accumulator);
        }, $initial_value);
    }
}

if(!function_exists('clean_hyphens')) {
    /**
     * Remove all hyphens from a string
     * 
     * @param string $subject The string to clean
     * @return string
     */
    function clean_hyphens(string $subject): string {
        return str_replace('-', '', $subject);
    }
}
