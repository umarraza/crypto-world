<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Roi;
use Illuminate\Http\Request;

class CronController extends Controller
{
    public function getPercentage() {

        $users = User::where('active', User::ACTIVE)->get();

        foreach($users as $user) {
            $sum = 0;

            $totalDeposit = $user->totalDeposit();
            $roi = $totalDeposit * (6/(30*100));
            $sum += $roi;

            $userRoi = Roi::create(['user_id' => $user->id, 'amount' => $roi]);

            $levelOneUsers = $user->getLevelOneUsers();
            $sum += $user->calculateTeamBonus($levelOneUsers,3); 

            $leveltWOUsers = $user->getLevelTwoUsers();
            $sum += $user->calculateTeamBonus($leveltWOUsers,1.5); 

            $levelThreeUsers = $user->getLevelThreeUsers();
            $sum += $user->calculateTeamBonus($levelThreeUsers,1.5);
            
            $levelFourUsers = $user->getLevelFourUsers();
            $sum += $user->calculateTeamBonus($levelFourUsers,0.75);

            $levelFiveUsers = $user->getLevelFiveUsers();
            $sum += $user->calculateTeamBonus($levelFiveUsers,0.375);

            $levelSixUsers = $user->getLevelSixUsers();
            $sum += $user->calculateTeamBonus($levelSixUsers,0.185);

            $user->current_balance += $sum;
            $user->save();
        }
    }
}
