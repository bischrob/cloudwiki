<?php

declare(strict_types=1);

namespace OCA\CloudWiki\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

class Application extends App implements IBootstrap
{
    public const APP_ID = 'cloudwiki';

    public function __construct(array $params = [])
    {
        parent::__construct(self::APP_ID, $params);
    }

    public function register(IRegistrationContext $context): void
    {
    }

    public function boot(IBootContext $context): void
    {
    }
}
