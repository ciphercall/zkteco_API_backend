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

    // Existing methods
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

    // Additional methods from the package
    public function connect()
    {
        return $this->zk->connect();
    }

    public function disconnect()
    {
        return $this->zk->disconnect();
    }

    public function enableDevice()
    {
        return $this->zk->enableDevice();
    }

    public function disableDevice()
    {
        return $this->zk->disableDevice();
    }

    public function restartDevice()
    {
        return $this->zk->restart();
    }

    public function shutdownDevice()
    {
        return $this->zk->shutdown();
    }

    public function sleepDevice()
    {
        return $this->zk->sleep();
    }

    public function resumeDevice()
    {
        return $this->zk->resume();
    }

    public function getDeviceVersion()
    {
        return $this->zk->getVersion();
    }

    public function getOSVersion()
    {
        return $this->zk->getOSVersion();
    }

    public function getPlatform()
    {
        return $this->zk->getPlatform();
    }

    public function clearAdmin()
    {
        return $this->zk->clearAdmin();
    }

    public function removeUser(int $uid)
    {
        return $this->zk->removeUser($uid);
    }

    public function testVoice()
    {
        return $this->zk->testVoice();
    }
}
