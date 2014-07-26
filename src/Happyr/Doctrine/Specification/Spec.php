<?php

namespace Happyr\Doctrine\Specification;

use Happyr\Doctrine\Specification\Spec\LogicX;
use Happyr\Doctrine\Specification\Spec as S;

class Spec
{
    public static $logic = ['andX', 'orX'];
    public static $comparison = ['eq', 'neq', 'gt', 'lt', 'gte', 'lte'];

    /**
     * Make a static call to this class to create a spec
     *
     * @param string $name the function called
     * @param array $arguments
     *
     * @return \Happyr\Doctrine\Specification\Spec\Specification
     * @throws \LogicException
     */
    public static function __callStatic($name, $arguments)
    {
        if (in_array($name, Spec::$logic)) {
            return new S\LogicX($name, $arguments);

        } elseif (in_array($name, Spec::$comparison)) {
            return new S\Comparison(
                constant('Happyr\Doctrine\Specification\Spec\Comparison::'.strtoupper($name)),
                array_pop($arguments),
                array_pop($arguments),
                array_pop($arguments)
            );

        } else {
            $name[0]=strtoupper($name[0]);
            $ns=sprintf('%s\Spec\%s', __NAMESPACE__, $name);

            if (class_exists($ns)) {
                $reflection = new \ReflectionClass($ns);
                return $reflection->newInstanceArgs($arguments);

            } else {
                throw new \LogicException(sprintf('Method "%s" was not found on %s.', $name, __CLASS__));
            }
        }
    }

    /**
     * Add a collection of specs
     *
     * @return LogicX
     */
    public static function collection()
    {
        return new S\LogicX(LogicX::AND_X, func_get_args());
    }
}
