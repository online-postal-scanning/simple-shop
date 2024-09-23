<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use Closure;

final class ObjectHasId
{
    public function __invoke($object, $idProperty = 'id'): bool
    {
        $reader = function & ($object, $idProperty) {
            $getter = 'get' . ucfirst($idProperty);
            if (method_exists($object, $getter)) {
                return $object->$getter();
            }
            $value = & Closure::bind(function & () use ($idProperty) {
                return $this->$idProperty;
            }, $object, $object)->__invoke();

            return $value;
        };

        $idValue = & $reader($object, $idProperty);

        return !empty($idValue);
    }
}
