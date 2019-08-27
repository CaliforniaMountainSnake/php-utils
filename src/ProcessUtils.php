<?php

namespace CaliforniaMountainSnake\UtilTraits;

/**
 * A trait to work with system processes.
 */
trait ProcessUtils
{
    /**
     * @param int $_pid
     *
     * @return string
     */
    protected function getPidUptime(int $_pid): string
    {
        return \trim(\exec('ps -o etime= -p "' . $_pid . '" '));
    }

    /**
     * @param string $_program
     *
     * @return array
     */
    protected function getAllProgramProcesses(string $_program): array
    {
        \exec('pgrep -a ' . $_program, $out);
        return $out;
    }

    /**
     * @param int $_pid
     * @param int $_code
     *
     * @return array
     */
    protected function killPid(int $_pid, int $_code = -15): array
    {
        // -15 - the code of "soft" process killing.
        \exec('kill ' . $_code . ' ' . $_pid, $out);
        return $out;
    }
}
