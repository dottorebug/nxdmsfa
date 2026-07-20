<?php

namespace OCA\NXDMSFA\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use OCP\AppFramework\Attribute\NoAdminRequired;

class PageController extends Controller {

	    public function __construct(string $appName, IRequest $request) {
		            parent::__construct($appName, $request);
			        }

	        #[NoAdminRequired]
	        public function index(): TemplateResponse {
			        return new TemplateResponse('nxdmsfa', 'main');
				    }
}

