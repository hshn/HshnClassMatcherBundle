<?php

namespace Hshn\ClassMatcherBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class ClassMatcherPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $provider = $container->getDefinition('hshn_class_matcher.matcher_provider');

        $map = [];
        foreach ($container->findTaggedServiceIds('class_matcher.matcher') as $id => $tags) {
            foreach ($tags as $tag) {
                if (isset($tag['alias'])) {
                    $map[$tag['alias']] = new Reference($id);
                }
            }
        }

        $provider->setArguments([$map]);
    }
}
