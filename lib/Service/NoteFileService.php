<?php

declare(strict_types=1);

namespace OCA\CloudWiki\Service;

use OCP\Files\File;
use OCP\Files\Folder;
use OCP\Files\IRootFolder;
use OCP\Files\NotFoundException;
use OCP\Files\NotPermittedException;
use OCP\IUserSession;

class NoteFileService
{
    public function __construct(
        private IRootFolder $rootFolder,
        private IUserSession $userSession,
    ) {
    }

    /**
     * @return array{path:string,content:string,etag:string,mtime:int}
     */
    public function open(string $path): array
    {
        $file = $this->resolveFile($path);

        if (!$file->isReadable()) {
            throw new NotPermittedException('File is not readable');
        }

        return [
            'path' => $file->getPath(),
            'content' => $file->getContent(),
            'etag' => $file->getEtag(),
            'mtime' => $file->getMTime(),
        ];
    }

    /**
     * @return array{path:string,etag:string,mtime:int}
     */
    public function save(string $path, string $content, ?string $expectedEtag): array
    {
        $file = $this->resolveFile($path);

        if (!$file->isUpdateable()) {
            throw new NotPermittedException('File is not updateable');
        }

        $currentEtag = $file->getEtag();
        if ($expectedEtag !== null && $expectedEtag !== '' && $expectedEtag !== $currentEtag) {
            throw new ConflictException($currentEtag, $file->getMTime());
        }

        $file->putContent($content);
        $file->stat();

        return [
            'path' => $file->getPath(),
            'etag' => $file->getEtag(),
            'mtime' => $file->getMTime(),
        ];
    }

    private function resolveFile(string $rawPath): File
    {
        $normalizedPath = $this->normalizePath($rawPath);
        $userFolder = $this->getUserFolder();

        $node = $userFolder->get($normalizedPath);
        if (!($node instanceof File)) {
            throw new NotFoundException('Path is not a file');
        }

        return $node;
    }

    private function normalizePath(string $rawPath): string
    {
        $path = trim($rawPath);
        if ($path === '') {
            throw new InvalidNotePathException('Path is required');
        }

        $path = ltrim($path, '/');
        if ($path === '') {
            throw new InvalidNotePathException('Path is required');
        }

        if (str_contains($path, '..') || str_contains($path, '\\')) {
            throw new InvalidNotePathException('Path contains invalid traversal tokens');
        }

        if (!str_ends_with(strtolower($path), '.md')) {
            throw new InvalidNotePathException('Only .md files are supported');
        }

        return $path;
    }

    private function getUserFolder(): Folder
    {
        $user = $this->userSession->getUser();
        if ($user === null) {
            throw new NotPermittedException('User is not authenticated');
        }

        return $this->rootFolder->getUserFolder($user->getUID());
    }
}
