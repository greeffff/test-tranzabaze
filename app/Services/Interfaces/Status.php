<?php


namespace App\Services\Interfaces;


interface Status
{
    /**
     * @param $status
     * @return mixed
     */
    public function setStatus($status);

    public function getStatus();
}
