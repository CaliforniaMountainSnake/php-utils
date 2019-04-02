<?php

namespace CaliforniaMountainSnake\UtilTraits;

/**
 * A trait to work with system processes.
 */
trait ProcessUtils
{

    protected function getPidUptime(int $_pid): string
    {
        return \trim(\exec('ps -o etime= -p "' . $_pid . '" '));
    }

    protected function getAllProgramProcesses(string $_program): array
    {
        \exec('pgrep -a ' . $_program, $out);
        return $out;
    }

    protected function killPid(int $_pid, int $_code = -15): array
    {
        // -15 - код "мягкого" завершения процесса.
        \exec('kill ' . $_code . ' ' . $_pid, $out);
        return $out;
    }

}
