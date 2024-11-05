<?php

namespace App\Http\Controllers;

use App\Services\ZKTecoService;
use Illuminate\Http\Request;

class ZKTecoController extends Controller
{
    protected $zkService;

    public function __construct(ZKTecoService $zkService)
    {
        $this->zkService = $zkService;
    }

    // Existing methods
    public function getAttendanceLogs()
    {
        return response()->json($this->zkService->getAttendanceLogs());
    }

    public function clearAttendanceLogs()
    {
        $this->zkService->clearAttendanceLogs();
        return response()->json(['message' => 'Attendance logs cleared.']);
    }

    public function setUser(Request $request)
    {
        $validatedData = $request->validate([
            'uid' => 'required|integer|max:65535',
            'userid' => 'required',
            'name' => 'required|string',
            'password' => 'nullable|string',
            'role' => 'nullable|integer',
            'cardno' => 'nullable|integer'
        ]);

        $result = $this->zkService->setUser(
            $validatedData['uid'],
            $validatedData['userid'],
            $validatedData['name'],
            $validatedData['password'] ?? '',
            $validatedData['role'] ?? \MehediJaman\LaravelZkteco\Lib\Util::LEVEL_USER,
            $validatedData['cardno'] ?? 0
        );

        return response()->json(['success' => $result]);
    }

    public function getDeviceInfo()
    {
        return response()->json(['device_info' => $this->zkService->getDeviceInfo()]);
    }

    // Additional methods
    public function connectDevice()
    {
        $result = $this->zkService->connect();
        return response()->json(['connected' => $result]);
    }

    public function disconnectDevice()
    {
        $result = $this->zkService->disconnect();
        return response()->json(['disconnected' => $result]);
    }

    public function enableDevice()
    {
        $result = $this->zkService->enableDevice();
        return response()->json(['device_enabled' => $result]);
    }

    public function disableDevice()
    {
        $result = $this->zkService->disableDevice();
        return response()->json(['device_disabled' => $result]);
    }

    public function restartDevice()
    {
        $result = $this->zkService->restartDevice();
        return response()->json(['device_restarted' => $result]);
    }

    public function shutdownDevice()
    {
        $result = $this->zkService->shutdownDevice();
        return response()->json(['device_shutdown' => $result]);
    }

    public function sleepDevice()
    {
        $result = $this->zkService->sleepDevice();
        return response()->json(['device_slept' => $result]);
    }

    public function resumeDevice()
    {
        $result = $this->zkService->resumeDevice();
        return response()->json(['device_resumed' => $result]);
    }

    public function getUsers()
    {
        $result = $this->zkService->getUsers();
        return response()->json(['Fetched Users' => $result]);
    }

    public function getOSVersion()
    {
        $result = $this->zkService->getOSVersion();
        return response()->json(['os_version' => $result]);
    }

    public function getPlatform()
    {
        $result = $this->zkService->getPlatform();
        return response()->json(['platform' => $result]);
    }

    public function clearAdmin()
    {
        $result = $this->zkService->clearAdmin();
        return response()->json(['admin_cleared' => $result]);
    }

    public function removeUser($uid)
    {
        $result = $this->zkService->removeUser($uid);
        return response()->json(['user_removed' => $result]);
    }

    public function testVoice()
    {
        $result = $this->zkService->testVoice();
        return response()->json(['voice_tested' => $result]);
    }

    public function syncAttendanceLogs()
    {
        $processedLogs = $this->processAttendanceLogs();

        foreach ($processedLogs as $log) {
            Attendance::updateOrCreate(
                [
                    'user_id' => $log['userId'],
                    'status' => 'present',
                    'created_at' => $log['date'], // Ensures a unique entry for each day per user
                ],
                [
                    'check_in' => $log['checkIn'],
                    'check_out' => $log['checkOut'],
                ]
            );
        }

        // Clear attendance logs from the device
        $this->zkService->clearAttendanceLogs();

        return response()->json(['message' => 'Attendance logs synced successfully']);
    }

    private function processAttendanceLogs()
    {
        $users = $this->zkService->getUsers();
        $attendanceLogs = $this->zkService->getAttendanceLogs();

        $logsByDateAndUser = [];

        foreach ($attendanceLogs as $log) {
            $date = (new \DateTime($log['timestamp']))->format('Y-m-d');
            $userKey = "{$log['id']}-{$date}";

            if (!isset($logsByDateAndUser[$userKey])) {
                $logsByDateAndUser[$userKey] = [
                    'userId' => $log['id'],
                    'userName' => $users[$log['id']]['name'] ?? 'Unknown User',
                    'date' => $date,
                    'checkIn' => $log['timestamp'],
                    'checkOut' => $log['timestamp'],
                ];
            } else {
                $logsByDateAndUser[$userKey]['checkIn'] = min($logsByDateAndUser[$userKey]['checkIn'], $log['timestamp']);
                $logsByDateAndUser[$userKey]['checkOut'] = max($logsByDateAndUser[$userKey]['checkOut'], $log['timestamp']);
            }
        }

        return array_values($logsByDateAndUser);
    }
}
