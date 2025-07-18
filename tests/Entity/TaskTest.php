<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Service\TaskService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase{
    // Verifier qu'on peut definir et recuperer le titre de la tache
    public function testDefinirTitreTache(){
        // Arrange = prepare une instance
        $tache = new Task();
        $TitreTache = 'Manger';

        // Act = definir l'action du test
        $tache->setTitle($TitreTache);

        // Assert = resultat du test
        $this->assertSame($TitreTache, $tache->getTitle());
    }
    // Test limites de caractère de la description
    public function testDescriptionValide(){
        $tache = new Task();
        $DescriptionTacheTropLong = str_repeat('a', 260);
        $this->expectException(\InvalidArgumentException::class);
        $tache->setDescription($DescriptionTacheTropLong);
    }
    // test mock User avec une vraie instance
    public function testSetUserWithInstance(){
        $tache = new Task();
        $user = new User();
        $tache->setUser($user);
        $this->assertSame($user, $tache->getUser());
    }
    // test stub 
    public function testCreerTacheAvecStub(){
        $tacheRepositoryStub = $this->createStub(TaskRepository::class);
        $entityManagerStub = $this->createStub(EntityManagerInterface::class);
        $userMock = $this->createMock(User::class);
        $tache = new Task();
        $taskService = new TaskService($tacheRepositoryStub, $entityManagerStub);
        $taskService->createTask($tache, $userMock);
        $this->assertSame($userMock, $tache->getUser());
    }
    // Test Description non vide sinon erreur
    public function testDescriptionNonVide(){
        $tache = new Task();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('La description de la tache ne doit pas être vide');
        
        $tache->setDescription(' ');
    }
}

?>