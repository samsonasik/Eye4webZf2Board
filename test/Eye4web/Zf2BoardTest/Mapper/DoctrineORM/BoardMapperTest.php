<?php

namespace Eye4web\Zf2BoardTest\Mapper\DoctrineORM;

use Eye4web\Zf2Board\Mapper\DoctrineORM\BoardMapper;
use PHPUnit_Framework_TestCase;

class BoardMapperTest extends PHPUnit_Framework_TestCase
{
    /** @var BoardMapper */
    protected $mapper;

    /** @var \Doctrine\ORM\EntityManager */
    protected $objectManager;

    /** @var \Eye4web\Zf2Board\Options\ModuleOptionsInterface */
    protected $options;

    public function setUp()
    {
        /** @var \Doctrine\ORM\EntityManager $objectManager */
        $objectManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->objectManager = $objectManager;

        /** @var \Eye4web\Zf2Board\Options\ModuleOptionsInterface $options */
        $options = $this->getMock('Eye4web\Zf2Board\Options\ModuleOptions');

        $this->options = $options;

        $mapper = new BoardMapper($objectManager, $options);

        $this->mapper = $mapper;
    }

    public function testFind()
    {
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $boardEntity = 'Eye4web\Zf2Board\Entity\Board';
        $board = $this->getMock($boardEntity);
        $boardId = 1;

        $this->options->expects($this->once())
                      ->method('getBoardEntity')
                      ->willReturn($boardEntity);

        $this->objectManager->expects($this->once())
                            ->method('getRepository')
                            ->with($boardEntity)
                            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
                         ->method('find')
                         ->with($boardId)
                         ->willReturn($board);

        $result = $this->mapper->find($boardId);

        $this->assertSame($board, $result);
    }

    public function testFindAll()
    {
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $boardEntity = '\Eye4web\Zf2Board\Entity\Board';
        $boards = [];

        $this->options->expects($this->once())
                      ->method('getBoardEntity')
                      ->willReturn($boardEntity);

        $this->objectManager->expects($this->once())
                            ->method('getRepository')
                            ->with($boardEntity)
                            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
                         ->method('findAll')
                         ->willReturn($boards);

        $result = $this->mapper->findAll();

        $this->assertSame($boards, $result);
    }
}
