<?php

namespace App\Http\Controllers;

use App\Models\Ressort;
use App\Models\RessortCategory;
use App\Models\RessortWorkShift;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class RessortsController extends Controller
{
    public function index()
    {
        return Inertia::render('Ressorts/Index', [
            'filters' => Request::all('search'),
            'ressortSelect' => Ressort::where('account_id', '=', Auth::user()->account->id)
                ->orderBy('name')
                ->get(),
            'ressorts' => Auth::user()->account->ressorts()
                ->join('ressort_categories', 'ressorts.ressort_category_id', '=', 'ressort_categories.id')
                ->orderBy('ressort_categories.name')
                ->select('ressorts.*', 'ressort_categories.name as ressortCategoryName', 'ressort_categories.deleted_at as ressortCategoryDeletedAt')
                ->filter(Request::only('search'))
                ->paginate(100)
                ->withQueryString()
                ->through(fn($ressort) => [
                    'id' => $ressort->id,
                    'ressort_category_id' => $ressort->ressort_category_id,
                    'ressort_category_name' => $ressort->ressortCategoryName,
                    'ressort_category_deleted_at' => $ressort->ressortCategoryDeletedAt,
                    'name' => $ressort->name,
                    'info' => mb_substr($ressort->info, 0, 50) . (strlen($ressort->info) > 50 ? '...' : ''),
                    'ressort_work_shifts_count' => $ressort->ressortWorkShifts->count(),
                ]),
        ]);
    }


    public function create()
    {
        return Inertia::render('Ressorts/Create',
            [
                'ressortCategorySelect' => RessortCategory::where('account_id', '=', Auth::user()->account->id)
                    ->orderBy('name')
                    ->get(),
            ]);
    }


    public function store()
    {
        Request::validate([
            'ressort_category_id' => ['required'],
            'name' => ['required', 'max:100'],
            'info' => ['nullable', 'max:5000'],
        ]);

        Auth::user()->account->ressorts()->create([
            'ressort_category_id' => Request::input('ressort_category_id'),
            'name' => Request::input('name'),
            'info' => Request::input('info'),
        ]);

        return Redirect::route('ressorts')->with('success', 'Ressort erstellt.');
    }


    public function edit(Ressort $ressort)
    {
        $ressort->load('ressortCategory');

        return Inertia::render('Ressorts/Edit', [
            'ressort' => [
                'id' => $ressort->id,
                'name' => $ressort->name,
                'info' => $ressort->info,
                'ressort_category_id' => $ressort->ressort_category_id,
            ],
            'ressortCategorySelect' => RessortCategory::where('account_id', '=', Auth::user()->account->id)
                ->orderBy('name')
                ->get()
        ]);
    }


    public function update(Ressort $ressort)
    {
        $ressort->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'info' => ['nullable', 'max:5000'],
                'ressort_category_id' => ['required', 'max:100'],
            ])
        );

        return Redirect::back()->with('success', 'Ressort aktualisiert.');
    }


    public function destroy(Ressort $ressort)
    {
        $ressort->delete();

        return Redirect::back()->with('success', 'Ressort gelöscht.');
    }


    public function restore(Ressort $ressort)
    {
        $ressort->restore();

        return Redirect::back()->with('success', 'Ressort wiederhergestellt.');
    }

    public function pdfRessortWorkShifts(Ressort $ressort, $day)
    {
        $ressortWorkShifts = RessortWorkShift::with('persons')->where('day', 'like', $day)->where('ressort_id', '=', $ressort->id)->get();

        $pdf = PDF::loadView('pdf.ressort', ['day' => strtoupper($day), 'ressortWorkShifts' => $ressortWorkShifts, 'ressort' => $ressort, 'account' => Auth::user()->account]);

        $filename = 'Ressourcenplan-' . strtoupper($day) . '-' . str_replace([' ', ',', '.'], ['_', '', ''], $ressort->name);

        $dangerousCharacters = array('"', "'", "&", "/", "\\", "?", "#", '<', '>');
        $filename = str_replace($dangerousCharacters, '', $filename);

        return $pdf->stream($filename . '.pdf');
    }
}
