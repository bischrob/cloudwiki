<?php

declare(strict_types=1);

namespace OCA\CloudWiki\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use OCP\Util;

class PageController extends Controller
{
    public function __construct(string $appName, IRequest $request)
    {
        parent::__construct($appName, $request);
    }

    #[NoAdminRequired]
    public function index(): TemplateResponse
    {
        Util::addScript('cloudwiki', 'cloudwiki-main');
        Util::addStyle('cloudwiki', 'style');

        return new TemplateResponse('cloudwiki', 'main');
    }
}
