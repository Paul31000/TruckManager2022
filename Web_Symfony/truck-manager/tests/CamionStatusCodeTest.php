<?php
namespace App\Tests;

use App\Entity\CamionStatus;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CamionStatusCodeTest extends KernelTestCase
{

    public function getEntity(): CamionStatus{
        return (new CamionStatus())
            ->setLatitude(12.52)
            ->setLongitude(12.52)
            ->setEnPanne(false)
            ->setEnPause(false)
            ->setArrive(false);}

    public function assertHasErrors(CamionStatus $code, int $number = 0){
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($code);
        $this->assertCount($number, $errors); }

    public function testValidCodeEntity(){
        $this->assertHasErrors($this->getEntity(), 0);}

    public function testInvalidBlankLongitudeEntity(){
        $this->assertHasErrors($this->getEntity()->setLongitude(null), 0);}

    public function testInvalidBlankLatitudeEntity(){
        $this->assertHasErrors($this->getEntity()->setLatitude(null), 0);}

    public function testInvalidBlankEnPanneEntity(){
        $this->assertHasErrors($this->getEntity()->setEnPanne(null), 0);}

    public function testInvalidBlankEnPauseEntity(){
        $this->assertHasErrors($this->getEntity()->setEnPause(null), 0);}

    public function testInvalidBlankArriveEntity(){
        $this->assertHasErrors($this->getEntity()->setArrive(null), 0);}
}