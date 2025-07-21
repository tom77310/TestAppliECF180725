<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Service\TaskService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase{
    // Test 1 : Test pour créer un Utilisateur
    public function testCreerUtilisateur(){
        // Arrange : Prepare l'instance 
        $user = new User();

        // Act = definit l'action du test 
        $user->setEmail('test@gmail.com');
        $user->setPassword('password');
        $user->setRoles(['ROLE_ADMIN']);

        // Assert = Resultat attendu du test
        $this->assertSame('test@gmail.com', $user->getEmail());
        $this->assertSame('password', $user->getPassword());
        $this->assertContains('ROLE_ADMIN', $user->getRoles());
        $this->assertContains('ROLE_USER', $user->getRoles()); // Role par defaut
    }
    // Test 2 : Verifier que les utilisateurs avec un role vide, ont le role par defaut
    public function testRoleNonVide(){
        //Arrange
        $user = new User();

        // Act
        $user->setRoles([]);

        // Assert
        $this->assertEquals(['ROLE_USER'], $user->getRoles());

    }
    // Test 3 : Erreur en cas d'email vide
    public function testErreurEmailVide(){
        $this->expectException(\TypeError::class);
        $user = new User();
        $user->setEmail(null);
    }
    // Test 4 : Test avec Mock : Ajout d'une tache avec mock
    public function testAjoutTacheAvecMock(){
    $user = new User();

    // On crée un mock partiel de la classe Task (setUser sera surveillée)
    $taskMock = $this->getMockBuilder(Task::class)
                     ->onlyMethods(['setUser'])
                     ->getMock();

    // On attend que setUser soit appelé une seule fois avec $user
    $taskMock->expects($this->once())
             ->method('setUser')
             ->with($this->equalTo($user));

    // On ajoute le mock au user
    $user->addTask($taskMock);

    // Vérifie que le mock a bien été ajouté à la collection
    $this->assertCount(1, $user->getTasks());

    }
    // Test 5 avec un stub : enlever une tache a l'utilisateur
    // public function testSupprimerTacheUtilisateur(){
    //         $user = new User();

    // // On crée un stub de Task
    // $taskStub = $this->getMockBuilder(Task::class)
    //                  ->onlyMethods(['setUser'])
    //                  ->getMock();

    // // Le stub retournera $user lorsqu'on appelle getUser()
    // $taskStub->method('getUser')
    //          ->willReturn($user);

    // // On attend que setUser(null) soit appelé une fois
    // $taskStub->expects($this->once())
    //          ->method('setUser')
    //          ->with(null);

    // // On force l'ajout de la tâche dans l'utilisateur (en contournant le contains)
    // $user->addTask($taskStub);
    // $this->assertCount(1, $user->getTasks());

    // // Maintenant, on la retire
    // $user->removeTask($taskStub);
    // $this->assertCount(0, $user->getTasks());
    // }
}

?>