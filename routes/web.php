<?php

use App\Models\Master\Deliverable;
use App\Models\Master\Team;
use App\Models\Project\Project;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
    // $teams = User::find(2)->createdTeams->toArray();
    // dd($teams);
    // foreach ($teams as $team) {
    //     dd($team);
    // }
    // $user = Team::find(4)->createdBy->toArray();

    // $team = new Team();
    // $teamWithUser = $team->where('id', 4)->with("createdBy")->get()->toArray();

    // $project = Project::where('id', 5)->with('deliverables')->get()->first();
    // $project = Deliverable::where('id', 1)->with('deliverables')->get()->toArray();
    // dd($project->deliverables->first()->toArray()['project_deliverables']['id']);


    // $users  = User::find(1)->toArray();
    // $users = new User();
    // $users = User::get();
    // $emails = $users->pluck('email')->all();
    // dd($users->pluck('email')->all());

    // $updatedEmails = $users->each(function ($item) {
    //     $item->is_verified = true;
    // });


    // $inActiveUsers = $users->filter(function ($item) {
    //     return $item->account_status == "inactive";
    // });

    // dd($inActiveUsers->toArray());

    // $todocollection = collect([
    //     [
    //         'user_id' => '1',
    //         'title' => 'Do Laundry',
    //         'description' => 'I have to do laundry '
    //     ],
    //     [
    //         'user_id' => '3',
    //         'title' => 'Finish Assignment',
    //         'description' => 'I have to finish Maths assignment '
    //     ],
    // ]);

    // dd($todocollection->where('user_id', 1)->all());

    // dd($users->contains('email', 'mquigley1@example.org'));


    // $projectCreated = User::find(92)->createdProjects->toArray();

    // $user = Project::find(1)->users->get()->toArray();

    // $user = Project::with('users')->find(1)->toArray();

    // dd(DB::last_query());


//     $user = User::OfType()->get()->toArray();
//     dd($user);
//     return $user;
// });