<?php


namespace Hshn\ClassMatcherBundle\Tests\ClassMatcher;


use Hshn\ClassMatcherBundle\ClassMatcher\ClassMatcherProvider;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class ClassMatcherProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function testGetThrowExceptionUnlessPassingValidName()
    {
        $provider = new ClassMatcherProvider([
            'foo' => true,
            'bar' => true,
        ]);

        $provider->get('pyo');
    }

    /**
     * @test
     */
    public function testGet()
    {
        $provider = new ClassMatcherProvider([
            'foo' => 'matcher-foo',
            'bar' => 'matcher-bar',
        ]);

        $this->assertEquals('matcher-foo', $provider->get('foo'));
    }
}
