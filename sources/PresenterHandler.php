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
namespace Nia\Routing\Handler;

use InvalidArgumentException;
use Nia\Collection\Map\StringMap\WriteableMapInterface;
use Nia\Presenter\PresenterInterface;
use Nia\RequestResponse\RequestInterface;
use Nia\RequestResponse\ResponseInterface;
use Nia\Routing\Handler\HandlerInterface;

/**
 * Route handler using a presenter and a presenter action to handle a request.
 */
class PresenterHandler implements HandlerInterface
{

    /**
     * The used presenter.
     *
     * @var PresenterInterface
     */
    private $presenter = null;

    /**
     * Name of the presenter action to handle the request.
     *
     * @var string
     */
    private $action = null;

    /**
     * Constructor.
     *
     * @param PresenterInterface $presenter
     *            The used presenter.
     * @param string $actionName
     *            Name of the presenter action to handle the request.
     * @throws InvalidArgumentException If the action does not exist in presenter.
     */
    public function __construct(PresenterInterface $presenter, string $actionName)
    {
        $this->presenter = $presenter;
        $this->action = $actionName . 'Action';

        if (! method_exists($this->presenter, $this->action)) {
            throw new InvalidArgumentException(sprintf('Action "%s" does not exist in presenter "%s".', $actionName, get_class($presenter)));
        }
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \Nia\Routing\Handler\HandlerInterface::handle($request, $context)
     */
    public function handle(RequestInterface $request, WriteableMapInterface $context): ResponseInterface
    {
        return $this->presenter->{$this->action}($request, $context);
    }
}
