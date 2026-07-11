<?php
/**
 * @package nxdmsfa
 * @copyright 2024 dottorebug
 * @license AGPL-3.0-or-later
 */

namespace OCA\Nxdmsfa\HostAdapter;

use OCP\IUserSession;
use OCP\ILogger;
use OCP\IRequest;

/**
 * Nextcloud-spezifische Implementierung des HostAdapterInterface.
 */
class NextcloudHostAdapter implements HostAdapterInterface
{
    private IUserSession $userSession;
    private ILogger $logger;
    private IRequest $request;

    public function __construct(IUserSession $userSession, ILogger $logger, IRequest $request)
    {
        $this->userSession = $userSession;
        $this->logger = $logger;
        $this->request = $request;
    }

    public function getCurrentUserId(): ?string
    {
        $user = $this->userSession->getUser();
        return $user ? $user->getUID() : null;
    }

    public function getHostName(): string
    {
        return 'nextcloud';
    }

    public function log(string $message, string $level = 'info'): void
    {
        $this->logger->log($level, $message, ['app' => 'nxdmsfa']);
    }

    public function getRequestUrl(): string
    {
        return $this->request->getUrl();
    }

    public function isLoggedIn(): bool
    {
        return $this->userSession->isLoggedIn();
    }
}
