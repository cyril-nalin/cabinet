<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
require __DIR__ . '/../models/Database.php';


final class DatabaseTest extends TestCase
{
    public function testCanConnect(): void
    {
        $con = Database::getConnexion();
        $this->assertNotNull($con);
    }

}


//TestCase::assertSame(1, 2);
?>