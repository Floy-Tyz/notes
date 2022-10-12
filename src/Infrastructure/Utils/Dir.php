<?php

namespace App\Infrastructure\Utils;

class Dir
{
    /**
     * @param string $dirPath
     * @return void
     */
    public static function checkDirectoryExist(string $dirPath): void
    {
        if (!is_dir($dirPath)){
            mkdir($dirPath, 0777, true);
        }
    }

    /**
     * @param string $dirPath
     * @return void
     */
    public static function rmdir(string $dirPath): void
    {
        if (!is_dir($dirPath)){
            return;
        }

        $objects = scandir($dirPath);

        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dirPath. DIRECTORY_SEPARATOR .$object) && !is_link($dirPath."/".$object))
                    self::rmdir($dirPath . DIRECTORY_SEPARATOR . $object);
                else
                    unlink($dirPath . DIRECTORY_SEPARATOR . $object);
            }
        }

        rmdir($dirPath);
    }
}