<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require __DIR__ . '/../models/Person.php';


final class PersonTest extends TestCase
{
    public function testConnexion(): void
    {
        $con = Database::getConnexion();
        $this->assertNotNull($con);

    }
    public function testCantLog(): void
    {
        $o = new Person();
        $res = $o->validateLogin('test@testjj.fr', 'testtest');
        $this->assertFalse($res);
    }

    public function testCanLog(): void
    {
        $o = new Person();

        $res = $o->validateLogin('test@test.fr', 'testtest');
        $this->assertNotFalse($res);
    }

}


//TestCase::assertSame(1, 2);
?>