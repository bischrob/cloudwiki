<?php

declare(strict_types=1);

namespace OCA\CloudWiki\AppInfo;

use OCP\AppFramework\App;

class Application extends App
{
    public const APP_ID = 'cloudwiki';

    public function __construct(array $params = [])
    {
        parent::__construct(self::APP_ID, $params);
    }
}
