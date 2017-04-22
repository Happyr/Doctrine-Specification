<?php
/**
 * Doctrine Specification.
 *
 * @author    Tobias Nyholm
 * @copyright Copyright (c) 2014, Tobias Nyholm
 * @license   http://opensource.org/licenses/MIT
 */

namespace tests\Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder;

use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\EqualsTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\FilterCollectionTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\GreaterOrEqualThanTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\GreaterThanTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\InstanceOfXTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\InTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\IsNotNullTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\IsNullTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\LessOrEqualThanTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\LessThanTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\LikeTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Filter\NotEqualsTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Logic\AndXTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Logic\NotTransformer;
use Happyr\DoctrineSpecification\Transformer\Doctrine\ORM\QueryBuilder\Logic\OrXTransformer;
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
//            new FilterCollectionTransformer($this),
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
//            new AndXTransformer($this),
//            new NotTransformer($this),
//            new OrXTransformer($this),
            new GroupByTransformer(),
//            new HavingTransformer($this),
//            new InnerJoinTransformer($this),
//            new JoinTransformer($this),
//            new LeftJoinTransformer($this),
//            new QueryModifierCollectionTransformer($this),
            new CountOfTransformer(),
            new LimitTransformer(),
            new OffsetTransformer(),
            new OrderByTransformer(),
        ]);
    }

    public function it_should_available_add_transformers()
    {
        $this->addTransformer(new EqualsTransformer());
//        $this->addTransformer(new FilterCollectionTransformer($this));
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
//        $this->addTransformer(new AndXTransformer($this));
//        $this->addTransformer(new NotTransformer($this));
//        $this->addTransformer(new OrXTransformer($this));
        $this->addTransformer(new GroupByTransformer());
//        $this->addTransformer(new HavingTransformer($this));
//        $this->addTransformer(new InnerJoinTransformer($this));
//        $this->addTransformer(new JoinTransformer($this));
//        $this->addTransformer(new LeftJoinTransformer($this));
//        $this->addTransformer(new QueryModifierCollectionTransformer($this));
        $this->addTransformer(new CountOfTransformer());
        $this->addTransformer(new LimitTransformer());
        $this->addTransformer(new OffsetTransformer());
        $this->addTransformer(new OrderByTransformer());
    }
}
