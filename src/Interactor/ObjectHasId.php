<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use Closure;

final class ObjectHasId
{
    public function __invoke($object, $idProperty = 'id'): bool
    {
        $reader = function & ($object, $idProperty) {
            $value = & Closure::bind(function & () use ($idProperty) {
                return $this->$idProperty;
            }, $object, $object)->__invoke();

            return $value;
        };

        $idValue = & $reader($object, $idProperty);

        return !empty($idValue);
    }
}
