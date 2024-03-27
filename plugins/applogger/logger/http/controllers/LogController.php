<?php
namespace AppLogger\Logger\Http\Controllers;

use AppLogger\Logger\Models\Log;
use AppUser\User\Services\AuthService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Response;

class LogController extends Controller {

    public function store(Request $request) {
        $data = $request->validate([
            'arrival_date' => 'required|date',
            'delay' => 'required|numeric'
        ]);
        $data['user_id'] = AuthService::getUser()->id;
        $log = Log::create($data);
        $log->save();

        return $log;
    }

    public function index() {
        return AuthService::getUser()->logs()->orderBy('arrival_date', 'desc')->get();
    }

    public function userLogs($user_id) {
        return Log::where('user_id', $user_id)->get();
    }

    public function checkArrival(Request $request) {
        $dateTime = $request->query('datetime');
        if (!$dateTime) {
            return Response(['error' => 'No param'], 400);
        }

        $arrivalDateTime = Carbon::parse($dateTime);
        return Log::where('arrival_date', '>=', $arrivalDateTime)->get();

    }
}
