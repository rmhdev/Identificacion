<?php

namespace Identificacion\Tests;

use Identificacion\IdentityInterface;

abstract class AbstractIdentityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getCorrectIdentityProvider
     * @param $actual
     */
    public function testCorrectIdentityMustBeValid($actual)
    {
        $identity = $this->createIdentity($actual);

        $this->assertTrue($identity->isValid());
    }

    /**
     * @param $code
     * @return IdentityInterface
     */
    protected abstract function createIdentity($code);

    abstract public function getCorrectIdentityProvider();

    /**
     * @dataProvider getIncorrectIdentityProvider
     * @param $actual
     */
    public function testIncorrectIdentityMustBeInvalid($actual)
    {
        $identity = $this->createIdentity($actual);

        $this->assertFalse($identity->isValid());
    }

    abstract public function getIncorrectIdentityProvider();

    /**
     * @dataProvider getToStringProvider
     * @param string $expected
     * @param string $actual
     */
    public function testToStringMustReturnCode($expected, $actual)
    {
        $identity = $this->createIdentity($actual);

        $this->assertEquals($expected, $identity->__toString());
    }

    abstract public function getToStringProvider();

    /**
     * @dataProvider getChecksumLetterProvider
     * @param string $expected
     * @param string $code
     */
    public function testChecksumLetterMustReturnLetter($expected, $code)
    {
        $identity = $this->createIdentity($code);

        $this->assertEquals($expected, $identity->checksumLetter());
    }

    abstract public function getChecksumLetterProvider();

    /**
     * @dataProvider getExpectedChecksumLetterProvider
     * @param string $expected
     * @param string $code
     */
    public function testExpectedChecksumLetterMustReturnLetter($expected, $code)
    {
        $identity = $this->createIdentity($code);

        $this->assertEquals($expected, $identity->expectedChecksumLetter());
    }

    abstract public function getExpectedChecksumLetterProvider();
}
