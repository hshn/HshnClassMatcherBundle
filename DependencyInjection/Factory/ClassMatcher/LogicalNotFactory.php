<?php

namespace Hshn\ClassMatcherBundle\DependencyInjection\Factory\ClassMatcher;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class LogicalNotFactory extends AbstractLogicalFactory
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'not';
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
                    return ['matcher' => $v];
                })
            ->end()
            ->children()
                ->scalarNode('matcher')->end()
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = new DefinitionDecorator('hshn_class_matcher.class_matcher.not.def');
        $definition->replaceArgument(0, $this->getMatcherReference($config['matcher']));

        $container->setDefinition($id, $definition);

        return $definition;
    }
}
