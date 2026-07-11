<?php
/**
 * @package nxdmsfa
 * @copyright 2024 dottorebug
 * @license AGPL-3.0-or-later
 */

namespace OCA\Nxdmsfa\Tests\HostAdapter;

use PHPUnit\Framework\TestCase;
use OCP\IUserSession;
use OCP\ILogger;
use OCP\IRequest;
use OCP\IUser;
use OCA\Nxdmsfa\HostAdapter\NextcloudHostAdapter;

/**
 * Unit tests for NextcloudHostAdapter.
 */
class NextcloudHostAdapterTest extends TestCase
{
    private IUserSession $userSession;
    private ILogger $logger;
    private IRequest $request;
    private NextcloudHostAdapter $adapter;

    protected function setUp(): void
    {
        $this->userSession = $this->createMock(IUserSession::class);
        $this->logger = $this->createMock(ILogger::class);
        $this->request = $this->createMock(IRequest::class);

        $this->adapter = new NextcloudHostAdapter(
            $this->userSession,
            $this->logger,
            $this->request
        );
    }

    public function testGetHostName(): void
    {
        $this->assertEquals('nextcloud', $this->adapter->getHostName());
    }

    public function testGetCurrentUserIdWhenLoggedIn(): void
    {
        $user = $this->createMock(IUser::class);
        $user->method('getUID')->willReturn('testuser');

        $this->userSession->method('getUser')->willReturn($user);
        $this->userSession->method('isLoggedIn')->willReturn(true);

        $this->assertEquals('testuser', $this->adapter->getCurrentUserId());
        $this->assertTrue($this->adapter->isLoggedIn());
    }

    public function testGetCurrentUserIdWhenNotLoggedIn(): void
    {
        $this->userSession->method('getUser')->willReturn(null);
        $this->userSession->method('isLoggedIn')->willReturn(false);

        $this->assertNull($this->adapter->getCurrentUserId());
        $this->assertFalse($this->adapter->isLoggedIn());
    }

    public function testLog(): void
    {
        $this->logger->expects($this->once())
            ->method('log')
            ->with(
                $this->equalTo('info'),
                $this->equalTo('Test message'),
                $this->equalTo(['app' => 'nxdmsfa'])
            );

        $this->adapter->log('Test message', 'info');
    }

    public function testGetRequestUrl(): void
    {
        $this->request->method('getUrl')->willReturn('/apps/nxdmsfa/hello');

        $this->assertEquals('/apps/nxdmsfa/hello', $this->adapter->getRequestUrl());
    }
}
