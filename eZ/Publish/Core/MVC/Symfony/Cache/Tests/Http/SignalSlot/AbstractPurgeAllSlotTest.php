<?php

/**
 * This file is part of the eZ Publish Kernel package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace eZ\Publish\Core\MVC\Symfony\Cache\Tests\Http\SignalSlot;

abstract class AbstractPurgeAllSlotTest extends AbstractSlotTest implements PurgeAllExpectation
{
    /**
     * @dataProvider getReceivedSignals
     */
    public function testReceivePurgesAll($signal)
    {
        $this->cachePurgerMock->expects($this->once())->method('purgeAll');
        $this->cachePurgerMock->expects($this->never())->method('purgeForContent');
        parent::receive($signal);
    }
}
