<?php

namespace Hshn\ClassMatcherBundle;

use Hshn\ClassMatcherBundle\DependencyInjection\Compiler\ClassMatcherPass;
use Hshn\ClassMatcherBundle\DependencyInjection\Factory\ClassMatcher;
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
        $container->addCompilerPass(new ClassMatcherPass());
    }
}
