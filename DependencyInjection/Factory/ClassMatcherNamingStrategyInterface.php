<?php


namespace Hshn\ClassMatcherBundle\DependencyInjection\Factory;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
interface ClassMatcherNamingStrategyInterface
{
    /**
     * @param string $name
     *
     * @return string
     */
    public function getServiceId($name);
}
