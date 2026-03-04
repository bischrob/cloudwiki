<?php

declare(strict_types=1);

namespace OCA\CloudWiki\Tests\Unit;

use OCA\CloudWiki\Service\ConflictException;
use OCA\CloudWiki\Service\NoteFileService;
use OCP\Files\File;
use OCP\Files\Folder;
use OCP\Files\IRootFolder;
use OCP\IUser;
use OCP\IUserSession;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class NoteFileServiceTest extends TestCase
{
    /** @var IRootFolder&MockObject */
    private IRootFolder $rootFolder;

    /** @var IUserSession&MockObject */
    private IUserSession $userSession;

    /** @var Folder&MockObject */
    private Folder $userFolder;

    /** @var IUser&MockObject */
    private IUser $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rootFolder = $this->createMock(IRootFolder::class);
        $this->userSession = $this->createMock(IUserSession::class);
        $this->userFolder = $this->createMock(Folder::class);
        $this->user = $this->createMock(IUser::class);

        $this->userSession->method('getUser')->willReturn($this->user);
        $this->user->method('getUID')->willReturn('alice');
        $this->rootFolder->method('getUserFolder')->with('alice')->willReturn($this->userFolder);
    }

    public function testSaveReturnsUpdatedEtagAndMtimeWhenWriteSucceeds(): void
    {
        /** @var File&MockObject $file */
        $file = $this->createMock(File::class);
        $this->userFolder->method('get')->with('Notes/Test.md')->willReturn($file);

        $file->method('isUpdateable')->willReturn(true);
        $file->expects(self::once())->method('putContent')->with('# Updated');
        $file->expects(self::once())->method('stat');
        $file->method('getPath')->willReturn('/alice/files/Notes/Test.md');
        $file->method('getEtag')->willReturnOnConsecutiveCalls('etag-before', 'etag-after');
        $file->method('getMTime')->willReturn(1772600000);

        $service = new NoteFileService($this->rootFolder, $this->userSession);
        $result = $service->save('Notes/Test.md', '# Updated', 'etag-before');

        self::assertSame('/alice/files/Notes/Test.md', $result['path']);
        self::assertSame('etag-after', $result['etag']);
        self::assertSame(1772600000, $result['mtime']);
    }

    public function testSaveThrowsConflictWhenExpectedEtagIsStale(): void
    {
        /** @var File&MockObject $file */
        $file = $this->createMock(File::class);
        $this->userFolder->method('get')->with('Notes/Test.md')->willReturn($file);

        $file->method('isUpdateable')->willReturn(true);
        $file->method('getEtag')->willReturn('current-etag');
        $file->method('getMTime')->willReturn(1772600101);
        $file->expects(self::never())->method('putContent');

        $service = new NoteFileService($this->rootFolder, $this->userSession);

        $this->expectException(ConflictException::class);
        $service->save('Notes/Test.md', '# Updated', 'stale-etag');
    }
}

