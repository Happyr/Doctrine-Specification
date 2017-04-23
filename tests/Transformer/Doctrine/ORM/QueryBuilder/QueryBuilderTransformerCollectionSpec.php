<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm <tobias@happyr.com>
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace tests\Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder;

use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\EqualsTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\GreaterOrEqualThanTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\GreaterThanTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\InstanceOfXTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\InTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\IsNotNullTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\IsNullTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\LessOrEqualThanTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\LessThanTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\LikeTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\Logic\AndXTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\Logic\NotTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\Logic\OrXTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\NotEqualsTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformerCollection;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryModifier\GroupByTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryModifier\HavingTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryModifier\InnerJoinTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryModifier\JoinTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryModifier\LeftJoinTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryModifier\QueryModifierCollectionTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\ResultManagement\CountOfTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\ResultManagement\LimitTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\ResultManagement\OffsetTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\ResultManagement\OrderByTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\ResultManagement\SliceTransformer;
use PhpSpec\ObjectBehavior;

/**
 * @mixin QueryBuilderTransformerCollection
 */
class QueryBuilderTransformerCollectionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith([]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformerCollection');
    }

    public function it_is_a_specification()
    {
        $this->shouldBeAnInstanceOf('Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\QueryBuilderTransformer');
    }

    public function it_should_available_set_transformer()
    {
        $this->beConstructedWith([
            new EqualsTransformer(),
            new GreaterOrEqualThanTransformer(),
            new GreaterThanTransformer(),
            new InstanceOfXTransformer(),
            new InTransformer(),
            new IsNotNullTransformer(),
            new IsNullTransformer(),
            new LessOrEqualThanTransformer(),
            new LessThanTransformer(),
            new LikeTransformer(),
            new NotEqualsTransformer(),
            new AndXTransformer(),
            new NotTransformer(),
            new OrXTransformer(),
            new GroupByTransformer(),
            new HavingTransformer(),
            new InnerJoinTransformer(),
            new JoinTransformer(),
            new LeftJoinTransformer(),
            new QueryModifierCollectionTransformer(),
            new CountOfTransformer(),
            new LimitTransformer(),
            new OffsetTransformer(),
            new OrderByTransformer(),
            new SliceTransformer(),
        ]);
    }

    public function it_should_available_add_transformers()
    {
        $this->addTransformer(new EqualsTransformer());
        $this->addTransformer(new GreaterOrEqualThanTransformer());
        $this->addTransformer(new GreaterThanTransformer());
        $this->addTransformer(new InstanceOfXTransformer());
        $this->addTransformer(new InTransformer());
        $this->addTransformer(new IsNotNullTransformer());
        $this->addTransformer(new IsNullTransformer());
        $this->addTransformer(new LessOrEqualThanTransformer());
        $this->addTransformer(new LessThanTransformer());
        $this->addTransformer(new LikeTransformer());
        $this->addTransformer(new NotEqualsTransformer());
        $this->addTransformer(new AndXTransformer());
        $this->addTransformer(new NotTransformer());
        $this->addTransformer(new OrXTransformer());
        $this->addTransformer(new GroupByTransformer());
        $this->addTransformer(new HavingTransformer());
        $this->addTransformer(new InnerJoinTransformer());
        $this->addTransformer(new JoinTransformer());
        $this->addTransformer(new LeftJoinTransformer());
        $this->addTransformer(new QueryModifierCollectionTransformer());
        $this->addTransformer(new CountOfTransformer());
        $this->addTransformer(new LimitTransformer());
        $this->addTransformer(new OffsetTransformer());
        $this->addTransformer(new OrderByTransformer());
        $this->addTransformer(new SliceTransformer());
    }
}
