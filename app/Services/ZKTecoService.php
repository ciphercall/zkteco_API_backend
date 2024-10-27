<?php

namespace App\Services;

use MehediJaman\LaravelZkteco\LaravelZkteco;
use MehediJaman\LaravelZkteco\Lib\Util;

class ZKTecoService
{
    protected $zk;

    public function __construct()
    {
        $this->zk = new LaravelZkteco(env('ZKTECO_DEVICE_IP'), env('ZKTECO_PORT'));
        $this->zk->connect();
    }

    public function getAttendanceLogs()
    {
        return $this->zk->getAttendance();
    }

    public function clearAttendanceLogs()
    {
        return $this->zk->clearAttendance();
    }

    public function setUser(int $uid, int|string $userid, string $name, int|string $password, int $role = Util::LEVEL_USER, int $cardno = 0)
    {
        return $this->zk->setUser(uid: $uid, userid: $userid, name: $name, password: $password, role: $role, cardno: $cardno);
    }

    public function getDeviceInfo()
    {
        return [
            'device_name' => $this->zk->getDeviceName(),
            'firmware_version' => $this->zk->getFirmwareVersion(),
            'device_serial' => $this->zk->getSerialNumber(),
        ];
    }
}
