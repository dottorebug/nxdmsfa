<?php

namespace OCA\NXDMSFA\AppInfo;

use OCP\AppFramework\App;
use OCP\INavigationManager;
use OCP\IURLGenerator;

class Application extends App {

    public function __construct() {
        parent::__construct('nxdmsfa');

        $container = $this->getContainer();

        $container->get(INavigationManager::class)
            ->add(function() use ($container) {
                $urlGenerator = $container->get(IURLGenerator::class);

                return [
                    'id' => 'nxdmsfa',
                    'order' => 10,
                    'href' => $urlGenerator->linkToRoute('nxdmsfa.page.index'),
                    'icon' => '',
                    'name' => 'NXDMSFA',
                ];
            });
    }
}
