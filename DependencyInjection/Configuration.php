<?php

namespace Hshn\ClassMatcherBundle\DependencyInjection;

use Hshn\ClassMatcherBundle\DependencyInjection\Factory\ClassMatcherFactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @var ClassMatcherFactoryInterface[]
     */
    private $matcherFactories;

    /**
     * @param ClassMatcherFactoryInterface[] $matcherFactories
     */
    public function __construct(array $matcherFactories)
    {
        $this->matcherFactories = $matcherFactories;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $root = $builder->root('hshn_class_matcher');

        $this->addClassMatcherSection($root);

        return $builder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addClassMatcherSection(ArrayNodeDefinition $node)
    {
        /* @var $classMatcherBuilder ArrayNodeDefinition */
        $classMatcherBuilder = $node
            ->children()
                ->arrayNode('matchers')
                ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->beforeNormalization()
                            ->ifTrue(function ($v) {
                                return !isset($v['type']);
                            })
                            ->then(function ($v) {
                                foreach ($this->matcherFactories as $matcherFactory) {
                                    if (array_key_exists($type = $matcherFactory->getType(), $v)) {
                                        $v['type'] = $type;
                                        break;
                                    }
                                }

                                return $v;
                            })
                        ->end()
                        ->children()
                            ->scalarNode('type')->isRequired()
                        ->end();

        foreach ($this->matcherFactories as $matcherFactory) {
            $classMatcherBuilder->append($this->buildMatcherNode($matcherFactory));
        }
    }

    /**
     * @param ClassMatcherFactoryInterface $matcherFactory
     *
     * @return ArrayNodeDefinition|NodeDefinition
     */
    private function buildMatcherNode(ClassMatcherFactoryInterface $matcherFactory)
    {
        $builder = new TreeBuilder();
        $root = $builder->root($matcherFactory->getType());
        $matcherFactory->addConfiguration($root);

        return $root;
    }
}
