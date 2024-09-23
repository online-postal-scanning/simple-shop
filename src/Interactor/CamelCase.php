<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

final class CamelCase
{
    public function __invoke(string $string, array $noStrip = []): string 
    {
        // non-alpha and non-numeric characters become spaces
        $string = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $string);
        $string = trim($string);
        // uppercase the first character of each word
        $string = ucwords($string);
        $string = str_replace(" ", "", $string);
        $string = lcfirst($string);

        return $string;
    }
}
