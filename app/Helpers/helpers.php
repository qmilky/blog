<?php
/**
 *  Common_helper.php
 *
 * @author gengzhiguo@xiongmaojinfu.com
 * $Id: Common_helper.php 2015-09-15 下午7:05 $
 */

if (!function_exists('isMobile')) {
    /**
     * Numeric
     *
     * @param   string $mobile
     *
     * @return  bool
     */
    function isMobile($mobile)
    {
        return (!preg_match("/^(?:13\d|14\d|17\d|15\d|18[0123456789])-?\d{5}(\d{3}|\*{3})$/", $mobile)) ? false : true;
    }
}