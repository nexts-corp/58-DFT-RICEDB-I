<?php

namespace apps\tracking\interfaces;

/**
 * @name Follow2Service
 * @uri /follow2
 * @description Follow2Service
 */
interface IFollow2Service {

    /**
     * @name upload
     * @uri /upload
     * @return String[] upload
     * @param file file
     * @param string uploadDate
     * @description upload excel
     */
    public function upload($file,$uploadDate);

    /**
     * @name lists
     * @uri /lists
     * @return String[] lists
     * @description lists
     */
    public function lists();
}
