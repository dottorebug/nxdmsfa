<?php
/**
 * @package nxdmsfa
 * @copyright 2024 dottorebug
 * @license AGPL-3.0-or-later
 */

namespace OCA\Nxdmsfa\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;
use OCA\Nxdmsfa\HostAdapter\NextcloudHostAdapter;
use OCA\Nxdmsfa\HostAdapter\HostAdapterInterface;

class Application extends App
{
    public function __construct()
    {
        parent::__construct('nxdmsfa');
    }

    public function registerServices(IAppContainer $container): void
    {
        // Registriere den NextcloudHostAdapter als HostAdapterInterface
        $container->registerService(
            HostAdapterInterface::class,
            function (IAppContainer $c) {
                return new NextcloudHostAdapter(
                    $c->getServer()->get(\OCP\IUserSession::class),
                    $c->getServer()->get(\OCP\ILogger::class),
                    $c->getServer()->get(\OCP\IRequest::class)
                );
            }
        );
    }
}
