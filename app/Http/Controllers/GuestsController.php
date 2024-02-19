<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class GuestsController extends Controller
{
    public function index()
    {
        return Inertia::render('Guests/Index', [
            'filters' => Request::all('search'),
            'filterChips' => Request::all('day'),
            'guests' => Auth::user()->account->guests()
                ->orderBy('name')
                ->filter(Request::only('search', 'day'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn($guest) => [
                    'id' => $guest->id,
                    'name' => $guest->name,
                    'days' => $guest->days,
                    'number_of_person' => $guest->number_of_person,
                    'note' => mb_substr($guest->note,0, 50) . (strlen($guest->note) > 50 ? '...' : ''),
                    'deleted_at' => $guest->deleted_at,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Guests/Create');
    }

    public function store()
    {
        Request::validate([
            'name' => ['required', 'max:50'],
            'days' => ['required', 'max:7'],
            'number_of_person' => ['required', 'max:99'],
            'note' => ['required', 'max:3000'],
        ]);

        Auth::user()->account->guests()->create([
            'name' => Request::input('name'),
            'days' => Request::input('days'),
            'number_of_person' => Request::input('number_of_person'),
            'note' => Request::input('note')
        ]);


        return Redirect::route('guests')->with('success', 'Gast erstellt.');
    }


    public function edit(Guest $guest)
    {
        return Inertia::render('Guests/Edit', [
            'guest' => [
                'id' => $guest->id,
                'name' => $guest->name,
                'days' => $guest->days,
                'number_of_person' => $guest->number_of_person,
                'note' => $guest->note,
                'deleted_at' => $guest->deleted_at
            ],
        ]);
    }

    public function update(Guest $guest)
    {
        $guest->update(
            Request::validate([
                'name' => ['required', 'max:50'],
                'days' => ['required', 'max:7'],
                'number_of_person' => ['required', 'max:99'],
                'note' => ['required', 'max:3000'],
            ])
        );

        return Redirect::back()->with('success', 'Gast aktualisiert.');
    }

    public function destroy(Guest $guest)
    {
        $guest->delete();

        return Redirect::back()->with('success', 'Gast gelöscht.');
    }

    public function restore(Guest $guest)
    {
        $guest->restore();

        return Redirect::back()->with('success', 'Gast wiederhergestellt.');
    }
}
