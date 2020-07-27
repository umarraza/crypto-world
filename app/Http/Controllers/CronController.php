<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Roi;
use Illuminate\Http\Request;
use DB;

class CronController extends Controller
{
    public function getPercentage() {

        $users = User::where('active', User::ACTIVE)->where('id','!=',1)->get();

        foreach($users as $user) {

            DB::beginTransaction();
            try {
                $sum = 0;

                $totalDeposit = $user->totalDeposit();
                $roi = $totalDeposit * (7/(30*100));
                // $sum += $roi;

                $userRoi = Roi::create(['user_id' => $user->id, 'amount' => $roi]);

                $levelOneUsers = $user->getUsersByRefferalLevel(User::LEVEL_ONE);
                $sum += $user->calculateTeamBonus($levelOneUsers,2); 

                $leveltWOUsers = $user->getUsersByRefferalLevel(User::LEVEL_TWO);
                $sum += $user->calculateTeamBonus($leveltWOUsers,1.5); 

                $levelThreeUsers = $user->getUsersByRefferalLevel(User::LEVEL_THREE);
                $sum += $user->calculateTeamBonus($levelThreeUsers,1);
                
                $levelFourUsers = $user->getUsersByRefferalLevel(User::LEVEL_FOUR);
                $sum += $user->calculateTeamBonus($levelFourUsers,0.75);

                $levelFiveUsers = $user->getUsersByRefferalLevel(User::LEVEL_FIVE);
                $sum += $user->calculateTeamBonus($levelFiveUsers,0.5);

                $levelSixUsers = $user->getUsersByRefferalLevel(User::LEVEL_SIX);
                $sum += $user->calculateTeamBonus($levelSixUsers,0.25);
                
                // $user->payment->current_balance += $sum;
                // $user->payment->save();

            } catch (Exception $e) {
                DB::rollBack();
            }

            DB::commit();
        }
    }
}
