<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

final class ExtractExpirationDate
{
    public function __invoke($expirationDate)
    {
        if ($dateParts = preg_match("/([0-9]+)([^0-9]+)([0-9]+)/", $expirationDate, $matches)) {
            return $this->handleNonNumeric($matches);
        }

        return $this->handleNumeric($expirationDate);
    }

    private function handleNonNumeric($matches): array
    {
        return [
            'month' => str_pad($matches[1], 2, '0', STR_PAD_LEFT),
            'year' => substr($matches[3], -2),
        ];
    }

    private function handleNumeric($expirationDate): array
    {
        $year = substr($expirationDate, -2);

        do {
            $expirationDate = substr($expirationDate, 0, -2);
        } while(strlen($expirationDate) > 2);

        return [
            'month' => str_pad($expirationDate, 2, '0', STR_PAD_LEFT),
            'year' => $year,
        ];
    }
}