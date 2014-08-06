<?php

namespace Hshn\ClassMatcherBundle\DependencyInjection\Factory\ClassMatcher;

use Hshn\ClassMatcherBundle\DependencyInjection\Factory\ClassMatcherFactoryInterface;
use Hshn\ClassMatcherBundle\DependencyInjection\Factory\ClassMatcherNamingStrategyInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
abstract class AbstractLogicalFactory implements ClassMatcherFactoryInterface
{
    /**
     * @var ClassMatcherNamingStrategyInterface
     */
    private $namingStrategy;

    /**
     * @param string $name
     *
     * @return Reference
     */
    protected function getMatcherReference($name)
    {
        return new Reference($this->namingStrategy->getServiceId($name));
    }

    /**
     * @param ClassMatcherNamingStrategyInterface $namingStrategy
     *
     * @return void
     */
    public function setNamingStrategy(ClassMatcherNamingStrategyInterface $namingStrategy)
    {
        $this->namingStrategy = $namingStrategy;
    }
}
