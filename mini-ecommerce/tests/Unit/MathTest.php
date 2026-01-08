<?php

namespace Tests\Unit;

use App\Services\SumTest;
use PHPUnit\Framework\TestCase;

use PHPUnit\Framework\Attributes\Test;

class MathTest extends TestCase
{
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    #[Test] 
    public function sum_calculation_works(): void
    {
        $sum = new SumTest();

        $calcul = $sum->sum(4, 4);

        $this->assertEquals(8, $calcul);
    }
}