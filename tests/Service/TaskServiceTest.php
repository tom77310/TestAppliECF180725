<?php
namespace App\Tests\Service;

use App\Entity\Task;
use App\Service\TaskService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskServiceTest extends KernelTestCase{
    private $taskService;
    private $entityManager;
    
     protected function setUp(): void
    {
        self::bootKernel();
        $container = self::$container;
        $this->taskService = $container->get(TaskService::class);
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
    }

    // Test  créer une tache dans la base de donnée
    public function testAjoutTacheBDD(){
        $tache = new Task();
        $tache->setTitle("train");
        $tache->setDescription("Article sur les trains");

        $this->entityManager->persist($tache);
        $this->entityManager->flush();
    }
}


?>