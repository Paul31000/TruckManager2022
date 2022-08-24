<?php
namespace App\Tests;

use App\Entity\Camion;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CamionCodeTest extends KernelTestCase
{

    public function getEntity(): Camion
    {
        return (new Camion())
            ->setImatriculation('JKLMLK');
    }

    public function assertHasErrors(Camion $code, int $number = 0)
    {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($code);
        $this->assertCount($number, $errors); 
   }

    public function testValidCodeEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidBlankImmatriculationEntity()
    {
        $this->assertHasErrors($this->getEntity()->setImatriculation(''), 1);
    }
    
}