<?php


namespace Hshn\ClassMatcherBundle\DependencyInjection\Factory\ClassMatcher;


use Hshn\ClassMatcherBundle\DependencyInjection\Factory\ClassMatcherFactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class AnythingFactory implements ClassMatcherFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'anything';
    }

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(ArrayNodeDefinition $builder)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = $container->getDefinition('hshn_class_matcher.class_matcher.anything.def');

        $container->setAlias($id, 'hshn_class_matcher.class_matcher.anything.def');

        return $definition;
    }
}
