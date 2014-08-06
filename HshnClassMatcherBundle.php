<?php

namespace Hshn\ClassMatcherBundle;

use Hshn\ClassMatcherBundle\DependencyInjection\Compiler\ClassMatcherPass;
use Hshn\ClassMatcherBundle\DependencyInjection\Factory\ClassMatcher;
use Hshn\ClassMatcherBundle\DependencyInjection\HshnClassMatcherExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class HshnClassMatcherBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        /* @var $extension HshnClassMatcherExtension */
        $extension = $container->getExtension('hshn_class_matcher');

        $extension
            ->addClassMatcherFactory(new ClassMatcher\EqualsFactory())
            ->addClassMatcherFactory(new ClassMatcher\ExtendedFactory())
            ->addClassMatcherFactory(new ClassMatcher\ImplementedFactory())
            ->addClassMatcherFactory(new ClassMatcher\AnythingFactory())
            ->addClassMatcherFactory(new ClassMatcher\LogicalAndFactory())
            ->addClassMatcherFactory(new ClassMatcher\LogicalOrFactory())
        ;

        $container->addCompilerPass(new ClassMatcherPass());
    }
}
