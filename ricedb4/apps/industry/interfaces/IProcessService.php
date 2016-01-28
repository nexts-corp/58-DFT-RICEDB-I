<?php

namespace apps\industry\interfaces;

/**
 * @name IProcessService
 * @uri /process
 * @description ประมูล
 */
interface IProcessService {
    /**
     * @name listsProcess
     * @uri /listsProcess
     * @return String[] lists Description
     * @description ผู้เสนอราคาสูงสุดต่อคลัง
     * @authen true
     */
    public function listsProcess();
} 