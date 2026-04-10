<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use App\Models\TeamInvitation;
use App\Mail\TeamInvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index()
    {
        $ownedTeams = Auth::user()->ownedTeams;
        $memberTeams = Auth::user()->teams;
        return view('teams.index', compact('ownedTeams', 'memberTeams'));
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000'
        ]);

        Team::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect('/teams')->with('success', 'Team is successfully created!');
    }

    public function show(Team $team)
    {
        if ($team->user_id !== Auth::id()) {
            abort(403);
        }

        $invitations = $team->invitations()->where('accepted_at', null)->where('declined_at', null)->get();
        return view('teams.show', compact('team', 'invitations'));
    }

    public function inviteMember(Request $request, Team $team)
    {
        if ($team->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;
        
        if ($email === Auth::user()->email) {
            return back()->with('error', 'You cannot invite yourself!');
        }

        $user = User::where('email', $email)->first();
        if ($user && $team->members()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'User is already a member of this team!');
        }

        $existingInvitation = TeamInvitation::where('team_id', $team->id)
            ->where('email', $email)
            ->where('accepted_at', null)
            ->where('declined_at', null)
            ->first();

        if ($existingInvitation) {
            return back()->with('error', 'Invitation has already been sent to that email!');
        }

        $token = Str::random(64);
        $invitation = TeamInvitation::create([
            'team_id' => $team->id,
            'email' => $email,
            'token' => $token
        ]);

        Mail::send(new TeamInvitationMail($invitation));

        return back()->with('success', 'Invitation successfully sent to ' . $email . '!');
    }

    public function removeMember(Team $team, User $user)
    {
        if ($team->user_id !== Auth::id()) {
            abort(403);
        }

        $team->members()->detach($user->id);

        return back()->with('success', 'Member is successfully removed!');
    }

    public function acceptInvitation($token)
    {
        $invitation = TeamInvitation::where('token', $token)->firstOrFail();

        if ($invitation->accepted_at || $invitation->declined_at) {
            return redirect('/teams')->with('error', 'Invitation has already been processed!');
        }

        if (Auth::user()->email !== $invitation->email) {
            return redirect('/login')->with('error', 'Please login with the email you were invited with.');
        }

        $invitation->update(['accepted_at' => now()]);
        $invitation->team->members()->syncWithoutDetaching(Auth::id());

        return redirect('/teams')->with('success', 'You have successfully joined the team ' . $invitation->team->name . '!');
    }

    public function declineInvitation($token)
    {
        $invitation = TeamInvitation::where('token', $token)->firstOrFail();

        if ($invitation->accepted_at || $invitation->declined_at) {
            return redirect('/teams')->with('error', 'Invitation has already been processed!');
        }

        $invitation->update(['declined_at' => now()]);

        return redirect('/teams')->with('success', 'You have declined the invitation from the team ' . $invitation->team->name . '.');
    }

    public function edit(Team $team)
    {
        if ($team->user_id !== Auth::id()) {
            abort(403);
        }

        return view('teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        if ($team->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000'
        ]);

        $team->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect('/teams')->with('success', 'Team is successfully updated!');
    }

    public function destroy(Team $team)
    {
        if ($team->user_id !== Auth::id()) {
            abort(403);
        }

        $team->delete();

        return redirect('/teams')->with('success', 'Team is successfully deleted!');
    }
}
    

