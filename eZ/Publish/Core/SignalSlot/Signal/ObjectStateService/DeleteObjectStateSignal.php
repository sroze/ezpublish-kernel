<?php

/**
 * DeleteObjectStateSignal class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 *
 * @version //autogentag//
 */
namespace eZ\Publish\Core\SignalSlot\Signal\ObjectStateService;

use eZ\Publish\Core\SignalSlot\Signal;

/**
 * DeleteObjectStateSignal class.
 */
class DeleteObjectStateSignal extends Signal
{
    /**
     * ObjectStateId.
     *
     * @var mixed
     */
    public $objectStateId;
}
