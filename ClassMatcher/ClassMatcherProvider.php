<?php


namespace Hshn\ClassMatcherBundle\ClassMatcher;


use Hshn\ClassMatcher\MatcherInterface;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class ClassMatcherProvider
{
    /**
     * @var array|\Hshn\ClassMatcher\MatcherInterface[]
     */
    private $matchers;

    /**
     * @param MatcherInterface[] $matchers
     */
    public function __construct(array $matchers)
    {
        $this->matchers = $matchers;
    }

    /**
     * @param string $name
     */
    public function get($name)
    {
        if (isset($this->matchers[$name])) {
            return $this->matchers[$name];
        }

        throw new \InvalidArgumentException(sprintf('No class matcher named "%s" was found', $name));
    }
}
