<?php

namespace Hshn\ClassMatcherBundle\DependencyInjection;

use Hshn\ClassMatcherBundle\DependencyInjection\Factory\ClassMatcher\AbstractLogicalFactory;
use Hshn\ClassMatcherBundle\DependencyInjection\Factory\ClassMatcherFactoryInterface;
use Hshn\ClassMatcherBundle\DependencyInjection\Factory\ClassMatcherNamingStrategyInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class HshnClassMatcherExtension extends Extension implements ClassMatcherNamingStrategyInterface
{
    /**
     * @var ClassMatcherFactoryInterface[]
     */
    private $classMatcherFactories;

    /**
     *
     */
    public function __construct()
    {
        $this->classMatcherFactories = [];
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration($this->classMatcherFactories);
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        if (isset($config['matchers'])) {
            $this->loadClassMatcher($container, $loader, $config['matchers']);
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param LoaderInterface  $loader
     * @param array            $config
     */
    private function loadClassMatcher(ContainerBuilder $container, LoaderInterface $loader, array $config)
    {
        $loader->load('class_matcher.yml');

        foreach ($config as $name => $matcher) {
            $factory = $this->getClassMatcherFactory($type = $matcher['type']);
            $definition = $factory->create($container, $id = $this->getServiceId($name), $matcher[$type]);
            $definition->setPublic(false);
            $definition->addTag('class_matcher.matcher', ['alias' => $name]);
        }
    }

    /**
     * @param ClassMatcherFactoryInterface $factory
     *
     * @return HshnClassMatcherExtension
     */
    public function addClassMatcherFactory(ClassMatcherFactoryInterface $factory)
    {
        $this->classMatcherFactories[$factory->getType()] = $factory;

        if ($factory instanceof AbstractLogicalFactory) {
            $factory->setNamingStrategy($this);
        }

        return $this;
    }

    /**
     * @param string $type
     *
     * @return ClassMatcherFactoryInterface
     * @throws \InvalidArgumentException
     */
    private function getClassMatcherFactory($type)
    {
        if (isset($this->classMatcherFactories[$type])) {
            return $this->classMatcherFactories[$type];
        }

        throw new \InvalidArgumentException("Specified ClassMatcher factory '{$type}' is not available.");
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceId($name)
    {
        return sprintf('hshn_security_voter_extra.class_matcher.%s', $name);
    }
}
