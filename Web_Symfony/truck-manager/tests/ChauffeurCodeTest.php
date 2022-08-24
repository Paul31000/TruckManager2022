<?php
namespace App\Tests;

use App\Entity\Chauffeur;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ChauffeurCodeTest extends KernelTestCase
{

    public function getEntity(): Chauffeur
    {
        return (new Chauffeur())
            ->setNomPrenom('Bastien DESPIS');
    }

    public function assertHasErrors(Chauffeur $code, int $number = 0)
    {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($code);
        $this->assertCount($number, $errors); 
   }

    public function testValidCodeEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidBlankNomPrenomEntity()
    {
        $this->assertHasErrors($this->getEntity()->setNomPrenom(''), 1);
    }
    
}