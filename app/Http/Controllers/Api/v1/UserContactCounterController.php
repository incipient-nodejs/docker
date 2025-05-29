<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\UserContactCounter;
use Illuminate\Http\Request;
use Carbon\Carbon;
class UserContactCounterController extends Controller
{

    public function store(Request $request){
        $request->validate([
            "user_id" => "required",
            "company_data_id" => "required",
            "contact_value" => "required",
            "contact_type" => "required",
        ]);

        $userContactCounter =  UserContactCounter::where([
            "user_id" => $request->user_id,
            "company_data_id" => $request->company_data_id,
            "contact_value" => $request->contact_value,
            "contact_type" => $request->contact_type
        ])->first();

        if(isset($userContactCounter->id)){
            $userContactCounter->update(['counter' => $userContactCounter->counter + 1]);
            return response()->json([], 202);
        }

        UserContactCounter::create($request->all());
        return response()->json([], 201);
    }

    public function getUser($id){
        return UserContactCounter::with('companyData')->where(["user_id" => $id])->orderBy('id', 'DESC')->limit(100)->get();
    }

    public function getCompanyCount($id){
        $sum = UserContactCounter::where(["company_data_id" => $id])->sum('counter');
        return response()->json((int) $sum, 200);
    }

    public function getWeek($id){
        //$now = Carbon::now()->subWeek();
        $now = Carbon::now();

        $weekDates = [];
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek = $now->copy()->endOfWeek();

        $userContactCounters = UserContactCounter::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->where(["company_data_id" => $id])
                ->get();

        for ($i = 0; $i < 7; $i++) {
            $day = $startOfWeek->copy()->addDays($i);
            $weekDates[strtolower($day->format('l'))] = $day->toDateString();
        }

        return response()->json((object) [
            "items" => $userContactCounters,
            "weeks" => $weekDates
        ], 200);
    }

}
