<?php
/**
 * @package nxdmsfa
 * @copyright 2024 dottorebug
 * @license AGPL-3.0-or-later
 */

namespace OCA\Nxdmsfa\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCA\Nxdmsfa\HostAdapter\HostAdapterInterface;

/**
 * Controller für die /hello-Route.
 */
class HelloController extends Controller
{
    private HostAdapterInterface $hostAdapter;

    public function __construct(
        IRequest $request,
        HostAdapterInterface $hostAdapter
    ) {
        parent::__construct('nxdmsfa', $request);
        $this->hostAdapter = $hostAdapter;
    }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    public function index(): JSONResponse
    {
        $userId = $this->hostAdapter->getCurrentUserId();
        $hostName = $this->hostAdapter->getHostName();
        $isLoggedIn = $this->hostAdapter->isLoggedIn();
        $requestUrl = $this->hostAdapter->getRequestUrl();

        $this->hostAdapter->log('HelloController::index aufgerufen', 'debug');

        return new JSONResponse([
            'message' => 'Hello from NXDMSFA!',
            'host' => $hostName,
            'user_id' => $userId,
            'is_logged_in' => $isLoggedIn,
            'request_url' => $requestUrl,
        ]);
    }
}
