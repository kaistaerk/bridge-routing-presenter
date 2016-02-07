<?php
/*
 * This file is part of the nia framework architecture.
 *
 * (c) 2016 - Patrick Ullmann <patrick.ullmann@nat-software.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);
namespace Test\Nia\Routing\Handler;

use PHPUnit_Framework_TestCase;
use Nia\Routing\Handler\PresenterHandler;
use Nia\Presenter\PresenterInterface;
use Nia\RequestResponse\RequestInterface;
use Nia\Collection\Map\StringMap\WriteableMapInterface;
use Nia\RequestResponse\ResponseInterface;
use Nia\Collection\Map\StringMap\Map;

/**
 * Unit test for \Nia\Routing\Handler\PresenterHandler.
 */
class PresenterHandlerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @covers \Nia\Routing\Handler\PresenterHandler::__construct
     */
    public function test__constructException()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        $presenter = $this->getMock(PresenterInterface::class);

        new PresenterHandler($presenter, 'unknown');
    }

    /**
     * @covers \Nia\Routing\Handler\PresenterHandler::handle
     */
    public function testHandle()
    {
        $presenter = new class() implements PresenterInterface {

            public function indexAction(RequestInterface $request, WriteableMapInterface $context): ResponseInterface
            {
                return $request->createResponse();
            }

            public function fooBarAction(RequestInterface $request, WriteableMapInterface $context): ResponseInterface
            {
                return $request->createResponse();
            }
        };

        $response = $this->getMock(ResponseInterface::class);

        $request = $this->getMock(RequestInterface::class);
        $request->expects($this->any())
            ->method('createResponse')
            ->will($this->returnValue($response));

        $handler = new PresenterHandler($presenter, 'index');
        $this->assertSame($response, $handler->handle($request, new Map()));

        $handler = new PresenterHandler($presenter, 'fooBar');
        $this->assertSame($response, $handler->handle($request, new Map()));
    }
}
