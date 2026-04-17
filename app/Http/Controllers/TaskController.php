<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\TeamInvitation;
use Barryvdh\DomPDF\Facade\Pdf;

class TaskController extends Controller
{
    public function inbox()
    {
        $invitations = TeamInvitation::where('email', Auth::user()->email)
            ->where('accepted_at', null)
            ->where('declined_at', null)
            ->with('team')
            ->get();
        
        return view('inbox', compact('invitations'));
    }

    public function index(Request $request)
    {
        $query = Task::where('user_id', Auth::id())->whereNull('team_id');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filter == 'done') {
            $query->where('status', 'done');
        } elseif ($request->filter == 'pending') {
            $query->where('status', 'pending');
        }

        $tasks = $query
            ->orderBy('favorite', 'desc')
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->orderByRaw("FIELD(status, 'pending', 'done')")
            ->latest()
            ->paginate(5);

        return view('tasks.index', compact('tasks'));
    }

    public function teamIndex(Request $request)
    {
        // Get team IDs where user is owner or member
        $ownedTeamIds = Auth::user()->ownedTeams()->pluck('teams.id')->toArray();
        $memberTeamIds = Auth::user()->teams()->select('teams.id')->pluck('teams.id')->toArray();
        $userTeamIds = array_merge($ownedTeamIds, $memberTeamIds);

        $query = Task::whereIn('team_id', $userTeamIds)
            ->with('team');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filter == 'done') {
            $query->where('status', 'done');
        } elseif ($request->filter == 'pending') {
            $query->where('status', 'pending');
        }

        $tasks = $query
        ->orderBy('favorite', 'desc')
        ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
        ->orderByRaw("FIELD(status, 'pending', 'done')")
        ->latest()
        ->get()
        ->groupBy('team_id');

        return view('tasks.team-index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function createTeamTask()
    {
        $ownedTeams = Auth::user()->ownedTeams;
        $memberTeams = Auth::user()->teams;
        return view('tasks.create-team', compact('ownedTeams', 'memberTeams'));
    }

    public function destroy($id)
    {
        Task::findorFail($id)->delete();
        return redirect('/tasks')->with('success', 'Task is successfully deleted!');
    }

    public function store(Request $request)
    {
        Task::create([
        'user_id' => Auth::id(),
        'team_id' => $request->team_id ?? null,
        'title' => $request->title,
        'description' => $request->description,
        'status' => 'pending',
        'priority' => $request->priority,
        'category' => $request->category,
        'deadline' => $request->deadline
        ]);

        return redirect('/tasks')->with('success', 'Task is successfully added!');
    }

    public function done($id)
    {
        $task = Task::findOrFail($id);
        $task->status = 'done';
        $task->save();

       $redirect = $task->team_id ? '/team-tasks' : '/tasks';
       return redirect($redirect)->with('success', 'Task is successfully updated!');
    }

    public function undone($id)
    {
        $task = Task::findOrFail($id);
        $task->status = 'pending';
        $task->save();

       $redirect = $task->team_id ? '/team-tasks' : '/tasks';
       return redirect($redirect)->with('success', 'Task marked as pending!');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'category' => $request->category,
            'deadline' => $request->deadline
    ]);

        return redirect('/tasks')->with('success', 'Task is successfully updated!');
    }

    public function favorite($id)
    {
        $task = Task::findOrFail($id);
        $task->favorite = !$task->favorite;
        $task->save();

    $redirect = $task->team_id ? '/team-tasks' : '/tasks';
    return redirect($redirect);
    }

    public function dashboard()
    {

        // ======================
        // MY TASK
        // ======================
        $my_total = Task::where('user_id', Auth::id())
            ->whereNull('team_id')
            ->count();

        $my_done = Task::where('user_id', Auth::id())
            ->whereNull('team_id')
            ->where('status','done')
            ->count();

        $my_pending = Task::where('user_id', Auth::id())
            ->whereNull('team_id')
            ->where('status','pending')
            ->count();

        // ======================
        // TEAM TASK
        // ======================
        $ownedTeamIds = Auth::user()->ownedTeams()->pluck('teams.id')->toArray();
        $memberTeamIds = Auth::user()->teams()->pluck('teams.id')->toArray();
        $userTeamIds = array_merge($ownedTeamIds, $memberTeamIds);

        $team_total = Task::whereIn('team_id', $userTeamIds)->count();

        $team_done = Task::whereIn('team_id', $userTeamIds)
            ->where('status','done')
            ->count();

        $team_pending = Task::whereIn('team_id', $userTeamIds)
            ->where('status','pending')
            ->count();

        return view('dashboard', compact(
            'my_total','my_done','my_pending',
            'team_total','team_done','team_pending'
        ));
    }

    public function export()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        $pdf = Pdf::loadView('tasks.pdf', compact('tasks'));
        return $pdf->download('tasks.pdf');
    }

    public function kanban(Request $request)
    {
        $teamId = $request->team_id;

        $query = Task::where('user_id', Auth::id())
            ->with('children'); 
            if ($teamId) {
                $query->where('team_id', $teamId);
            }

            $tasks = $query->get()->groupBy('status');

            // ambil semua team user
            $teams = Auth::user()->teams()->get();
            return view('tools.kanban', compact('tasks', 'teams', 'teamId'));
    }

    public function move(Request $request, $id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        $task->status = $request->status;
        $task->save();

        return response()->json(['success' => true]);
    }

    public function calendar(Request $request)
    {
        $teamId = $request->team_id;

        $query = Task::where('user_id', Auth::id());

        if ($teamId) {
            $query->where('team_id', $teamId);
        }

        $tasks = $query->get();

        $teams = Auth::user()->teams()->get();

        $events = $tasks->map(function ($t) {
            return [
                'title' => $t->title,
                'start' => $t->deadline,
                'color' => match ($t->status) {
                    'pending' => '#f59e0b',
                    'in_progress' => '#3b82f6',
                    'done' => '#10b981',
                    default => '#6b7280'
                }
            ];
        });

        return view('tools.calendar', compact('events', 'teams', 'teamId'));
    }

}