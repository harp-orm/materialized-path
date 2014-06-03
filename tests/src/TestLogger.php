<?php

namespace Harp\MP\Test;

use Psr\Log\AbstractLogger;
use Harp\Query\Compiler\Compiler;

/**
 * A dummy logger used for testing
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2014, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class TestLogger extends AbstractLogger
{
    /**
     * @var array
     */
    protected $entries = array();

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        $this->entries []= isset($context['parameters']) ? Compiler::humanize($message, $context['parameters']) : $message;
    }

    /**
     * @return array
     */
    public function getEntries()
    {
        return $this->entries;
    }
}
