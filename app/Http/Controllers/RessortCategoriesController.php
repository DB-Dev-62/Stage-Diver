<?php

namespace App\Http\Controllers;

use App\Models\RessortCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class RessortCategoriesController extends Controller
{
    public function index()
    {
        return Inertia::render('RessortCategories/Index', [
            'filters' => Request::all('search'),
            'ressortCategories' => Auth::user()->account->ressortCategories()
                ->orderBy('name')
                ->filter(Request::only('search'))
                ->paginate(100)
                ->withQueryString()
                ->through(fn ($ressort_categories) => [
                    'id' => $ressort_categories->id,
                    'name' => $ressort_categories->name,
                ]),
        ]);
    }



    public function create()
    {
        return Inertia::render('RessortCategories/Create');
    }



    public function store()
    {
        Request::validate([
            'name' => ['required'],
        ]);

        Auth::user()->account->ressortCategories()->create([
            'name' => Request::input('name'),
        ]);

        return Redirect::route('ressort-categories')->with('success', 'RessortCategories erstellt.');
    }



    public function edit(RessortCategory $ressortCategory)
    {
        return Inertia::render('RessortCategories/Edit', [
            'ressortCategories' => [
                'id' => $ressortCategory->id,
                'name' => $ressortCategory->name,

            ],
        ]);
    }



    public function update(RessortCategory $ressortCategory)
    {
        $ressortCategory->update(
            Request::validate([
                'name' => ['required', 'max:100'],
            ])
        );

        return Redirect::back()->with('success', 'RessortCategories aktualisiert.');
    }



    public function destroy(RessortCategory $ressortCategory)
    {
        $ressortCategory->delete();

        return Redirect::back()->with('success', 'RessortCategories gelöscht.');
    }



    public function restore(RessortCategory $ressort_categories)
    {
        $ressort_categories->restore();

        return Redirect::back()->with('success', 'RessortCategories wiederhergestellt.');
    }
}
