<?php


namespace Hshn\ClassMatcherBundle\DependencyInjection\Factory\ClassMatcher;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class LogicalAndFactory extends AbstractLogicalFactory
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'and';
    }

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(ArrayNodeDefinition $builder)
    {
        $builder
            ->prototype('scalar')
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $definition = new DefinitionDecorator('hshn_class_matcher.class_matcher.and.def');
        $definition->replaceArgument(0, array_map(function ($matcher) {
            return $this->getMatcherReference($matcher);
        }, $config));

        $container->setDefinition($id, $definition);

        return $definition;
    }
}
