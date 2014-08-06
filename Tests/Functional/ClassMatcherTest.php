<?php


namespace Hshn\ClassMatcherBundle\Tests\Functional;

use Hshn\ClassMatcherBundle\ClassMatcher\ClassMatcherProvider;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class ClassMatcherTest extends WebTestCase
{
    /**
     * @test
     */
    public function test()
    {
        $provider = $this->getProvider();

        $this->assertInstanceOf('Hshn\ClassMatcher\Matcher\EqualsTo', $provider->get('m1'));
        $this->assertInstanceOf('Hshn\ClassMatcher\Matcher\Extended', $provider->get('m2'));
        $this->assertInstanceOf('Hshn\ClassMatcher\Matcher\Implemented', $provider->get('m3'));
    }

    /**
     * @return ClassMatcherProvider
     */
    private function getProvider()
    {
        return $this->get('hshn_class_matcher.matcher_provider');
    }
}
