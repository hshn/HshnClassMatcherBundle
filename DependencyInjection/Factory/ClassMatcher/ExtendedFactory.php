<?php


namespace Hshn\ClassMatcherBundle\DependencyInjection\Factory\ClassMatcher;


use Hshn\ClassMatcherBundle\DependencyInjection\Factory\ClassMatcherFactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class ExtendedFactory implements ClassMatcherFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'extended';
    }

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(ArrayNodeDefinition $builder)
    {
        $builder
            ->beforeNormalization()
                ->ifString()
                ->then(function ($v) {
                    return ['class' => $v];
                })
            ->end()
            ->children()
                ->scalarNode('class')->end()
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = new DefinitionDecorator('hshn_class_matcher.class_matcher.extended.def');
        $definition->replaceArgument(0, $config['class']);

        $container->setDefinition($id, $definition);

        return $definition;
    }
}
