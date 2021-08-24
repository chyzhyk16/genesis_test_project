<?php

namespace App\Tests\Service;

use App\Service\Btc;
use PHPUnit\Framework\TestCase;

class BtcTest extends TestCase
{
    public function testGetBtcRate(): void
    {
        $btc = new Btc();
        $this->assertIsFloat($btc->getBtcRate());
    }
}
