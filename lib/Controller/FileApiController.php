<?php

declare(strict_types=1);

namespace OCA\CloudWiki\Controller;

use OCA\CloudWiki\Service\ConflictException;
use OCA\CloudWiki\Service\InvalidNotePathException;
use OCA\CloudWiki\Service\NoteFileService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\DataResponse;
use OCP\Files\NotFoundException;
use OCP\Files\NotPermittedException;
use OCP\IRequest;
use Throwable;

class FileApiController extends Controller
{
    public function __construct(
        string $appName,
        IRequest $request,
        private NoteFileService $noteFileService,
    ) {
        parent::__construct($appName, $request);
    }

    #[NoAdminRequired]
    public function open(): DataResponse
    {
        $path = (string) $this->request->getParam('path', '');

        try {
            $fileData = $this->noteFileService->open($path);
            return new DataResponse($fileData, Http::STATUS_OK);
        } catch (InvalidNotePathException $e) {
            return new DataResponse(['error' => $e->getMessage()], Http::STATUS_BAD_REQUEST);
        } catch (NotFoundException $e) {
            return new DataResponse(['error' => 'File not found'], Http::STATUS_NOT_FOUND);
        } catch (NotPermittedException $e) {
            return new DataResponse(['error' => 'Permission denied'], Http::STATUS_FORBIDDEN);
        } catch (Throwable $e) {
            return new DataResponse(['error' => 'Unable to open file'], Http::STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    #[NoAdminRequired]
    public function save(): DataResponse
    {
        $rawBody = file_get_contents('php://input');
        $payload = is_string($rawBody) ? json_decode($rawBody, true) : null;
        if (!is_array($payload)) {
            return new DataResponse(['error' => 'Invalid JSON body'], Http::STATUS_BAD_REQUEST);
        }

        $path = is_string($payload['path'] ?? null) ? $payload['path'] : '';
        $content = is_string($payload['content'] ?? null) ? $payload['content'] : null;
        $expectedEtag = is_string($payload['expectedEtag'] ?? null) ? $payload['expectedEtag'] : null;

        if ($content === null) {
            return new DataResponse(['error' => 'content is required'], Http::STATUS_BAD_REQUEST);
        }

        try {
            $saveData = $this->noteFileService->save($path, $content, $expectedEtag);
            return new DataResponse($saveData, Http::STATUS_OK);
        } catch (InvalidNotePathException $e) {
            return new DataResponse(['error' => $e->getMessage()], Http::STATUS_BAD_REQUEST);
        } catch (ConflictException $e) {
            return new DataResponse([
                'error' => $e->getMessage(),
                'currentEtag' => $e->getCurrentEtag(),
                'currentMtime' => $e->getCurrentMtime(),
            ], Http::STATUS_CONFLICT);
        } catch (NotFoundException $e) {
            return new DataResponse(['error' => 'File not found'], Http::STATUS_NOT_FOUND);
        } catch (NotPermittedException $e) {
            return new DataResponse(['error' => 'Permission denied'], Http::STATUS_FORBIDDEN);
        } catch (Throwable $e) {
            return new DataResponse(['error' => 'Unable to save file'], Http::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
