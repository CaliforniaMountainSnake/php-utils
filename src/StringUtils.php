<?php

namespace CaliforniaMountainSnake\UtilTraits;

trait StringUtils
{
    /**
     * Get classname without namespace.
     *
     * @param $_classname_or_object
     *
     * @return string
     * @throws \ReflectionException
     */
    protected function getShortClassname($_classname_or_object): string
    {
        $reflect = new \ReflectionClass ($_classname_or_object);
        return $reflect->getShortName();
    }

    /**
     * Get human readable filesize.
     *
     * @see https://stackoverflow.com/questions/15188033/human-readable-file-size
     *
     * @param int $_size_in_bytes
     *
     * @return string
     */
    protected function getHumanReadableFileSize(int $_size_in_bytes): string
    {
        if ($_size_in_bytes === 0) {
            return '0.00 B';
        }

        $s = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        $e = \floor(\log($_size_in_bytes, 1024));

        return \round($_size_in_bytes / (1024 ** $e), 2) . ' ' . $s[(string)$e];
    }

}
