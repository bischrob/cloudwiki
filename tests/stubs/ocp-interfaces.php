<?php

declare(strict_types=1);

namespace OCP\Files;

if (!interface_exists(IRootFolder::class)) {
    interface IRootFolder
    {
        public function getUserFolder(string $uid);
    }
}

if (!interface_exists(Folder::class)) {
    interface Folder
    {
        public function get(string $path);
    }
}

if (!interface_exists(File::class)) {
    interface File
    {
        public function isReadable(): bool;
        public function isUpdateable(): bool;
        public function getContent(): string;
        public function putContent($data): int|false;
        public function getPath(): string;
        public function getEtag(): string;
        public function getMTime(): int;
        public function stat(): array;
    }
}

if (!class_exists(NotFoundException::class)) {
    class NotFoundException extends \RuntimeException
    {
    }
}

if (!class_exists(NotPermittedException::class)) {
    class NotPermittedException extends \RuntimeException
    {
    }
}

namespace OCP;

if (!interface_exists(IUser::class)) {
    interface IUser
    {
        public function getUID(): string;
    }
}

if (!interface_exists(IUserSession::class)) {
    interface IUserSession
    {
        public function getUser(): ?IUser;
    }
}

