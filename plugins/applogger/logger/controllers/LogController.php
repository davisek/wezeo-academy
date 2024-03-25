<?php
namespace AppLogger\Logger\Controllers;

use AppLogger\Logger\Models\Log;
use AppUser\User\Services\AuthService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use October\Rain\Database\ModelException;
use Response;

class LogController extends Controller {

    // Pridávanie nového logu
    public function store(Request $request) {
        try {
            $user = AuthService::getUserByToken($request->bearerToken());

            $log = new Log;
            $log->datum_prichodu =  $request->input('datum_prichodu');
            $log->user_id = $user->id;
            $log->meskanie = $request->input('meskanie');
            $log->save();

            return Response::json($log);
        }  catch (ModelException $ex) {
            return Response::json($ex->getMessage());
        }
    }

    // Vracanie všetkých logov od posledného príchodu
    public function index(Request $request) {
        $user = AuthService::getUserByToken($request->bearerToken());
        if (!$user) {
            return Response::json(['error' => 'Unauthorized'], 401);
        }
        $logs = $user->logs()->orderBy('datum_prichodu', 'desc')->get();
        return Response::json($logs);
    }

    // Vracanie Logov vybraného užívateľa
    public function userLogs($user_id) {
        $logs = Log::where('user_id', $user_id)->get();

        return Response::json($logs);
    }

    // Vracia Logy, kde prišiel užívateľ neskôr, ako daný čas v parametry
    public function checkArrival(Request $request)
    {
        $dateTime = $request->query('datetime');

        if ($dateTime !== null) {
            $arrivalDateTime = Carbon::parse($dateTime);
            $logs = Log::where('datum_prichodu', '>=', $arrivalDateTime)->get();
            return Response::json($logs);
        } else {
            return Response::json(['error' => 'Parameter je nutný'], 400);
        }
    }

    public function test() {
        return 'TEST PAGE';
    }

}
