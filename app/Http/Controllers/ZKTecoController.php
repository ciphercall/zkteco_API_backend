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
}
