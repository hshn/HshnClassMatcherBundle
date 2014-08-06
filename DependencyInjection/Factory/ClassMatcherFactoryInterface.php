<?php

namespace Hshn\ClassMatcherBundle\DependencyInjection\Factory;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
interface ClassMatcherFactoryInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @param ArrayNodeDefinition $builder
     *
     * @return void
     */
    public function addConfiguration(ArrayNodeDefinition $builder);

    /**
     * @param ContainerBuilder $container
     * @param string           $id
     * @param array            $config
     *
     * @return Definition
     */
    public function create(ContainerBuilder $container, $id, array $config);
}
