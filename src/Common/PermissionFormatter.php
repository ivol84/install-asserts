<?php
namespace ivol\Common;

/**
 * Helper class. Allows to format return value of fileperm function
 *
 * @package ivol\Common
 */
class PermissionFormatter
{
    /**
     * @param $permissions
     * @return string
     */
    public static function getOctal($permissions)
    {
        return decoct($permissions & 0777);
    }
}