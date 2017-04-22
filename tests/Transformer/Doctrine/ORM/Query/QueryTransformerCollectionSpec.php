<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace tests\Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Query;

use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Query\QueryTransformerCollection;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Query\ResultModifier\AsArrayTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Query\ResultModifier\AsSingleScalarTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Query\ResultModifier\CacheTransformer;
use PhpSpec\ObjectBehavior;

/**
 * @mixin QueryTransformerCollection
 */
class QueryTransformerCollectionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith([]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Query\QueryTransformerCollection');
    }

    public function it_is_a_specification()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\Query\QueryTransformer');
    }

    public function it_should_available_set_transformer()
    {
        $this->beConstructedWith([
            new AsArrayTransformer(),
            new AsSingleScalarTransformer(),
            new CacheTransformer(),
        ]);
    }

    public function it_should_available_add_transformers()
    {
        $this->addTransformer(new AsArrayTransformer());
        $this->addTransformer(new AsSingleScalarTransformer());
        $this->addTransformer(new CacheTransformer());
    }
}
