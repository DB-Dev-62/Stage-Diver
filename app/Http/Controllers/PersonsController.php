<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\RessortCategory;
use App\Models\RessortWorkShift;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request as RequestHttp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class PersonsController extends Controller
{


    public function index()
    {

        $query = Auth::user()->account->ressortCategories()
            ->select('name', 'id')
            ->orderBy('name');

        $ressortCategorySelect = $query->get()->pluck('name', 'id')->toArray();

        $newKeys = array_map(function ($k) {
            return '_' . $k;
        }, array_keys($ressortCategorySelect));
        $ressortCategorySelect = array_combine($newKeys, $ressortCategorySelect);
        $ressortCategorySelectNone['none'] = 'Kein Ressort';
        $ressortCategorySelect = array_merge($ressortCategorySelectNone, $ressortCategorySelect);


        return Inertia::render('Persons/Index', [
            'filters' => Request::all('search'),
            'filterChips' => Request::all('year', 'registered', 'friday', 'saturday', 'sunday', 't_shirt_size', 't_shirt_picked_up', 'food', 'allergies', 'note', 'other', 'ressort_category_name'),


            'ressortCategorySelect' => $ressortCategorySelect,

            'persons' => Auth::user()->account->persons()
                ->with('ressortWorkShifts')
                ->leftjoin('ressort_categories', 'persons.ressort_category_id', '=', 'ressort_categories.id')
                ->orderBy('name')
                ->select('persons.*', 'ressort_categories.name as ressortCategoryName', 'ressort_categories.deleted_at as ressortCategoryDeletedAt')
                ->filter(Request::only('search', 'year', 'registered', 'friday', 'saturday', 'sunday', 't_shirt_size', 't_shirt_picked_up', 'food', 'allergies', 'note', 'other', 'ressort_category_name'))
                ->paginate(100)
                ->withQueryString()
                ->through(fn($person) => [
                    'id' => $person->id,
                    'name' => $person->name,
                    'ressort_category_id' => $person->ressort_category_id,
                    'ressort_category_name' => $person->ressortCategoryName,
                    'ressort_category_deleted_at' => $person->ressortCategoryDeletedAt,
                    'ressort' => $person->ressort ? $person->ressort->name : '',
                    'ressortWorkShifts' => $person->ressortWorkShifts,
                    'phone' => $person->phone,
                    'email' => $person->email,
                    'year' => $person->year,
                    'registered' => $person->registered,
                    'friday' => $person->friday,
                    'friday_beer' => $person->friday_beer,
                    'saturday' => $person->saturday,
                    'saturday_beer' => $person->saturday_beer,
                    'sunday' => $person->sunday,
                    'sunday_beer' => $person->sunday_beer,
                    't_shirt_size' => $person->t_shirt_size,
                    't_shirt_picked_up' => $person->t_shirt_picked_up,
                    'food' => $person->food,
                    'allergies' => mb_substr($person->allergies, 0, 20) . (strlen($person->allergies) > 20 ? '...' : ''),
                    'other' => mb_substr($person->other, 0, 20) . (strlen($person->other) > 20 ? '...' : ''),
                    'note' => mb_substr($person->note, 0, 20) . (strlen($person->note) > 20 ? '...' : ''),
                    'deleted_at' => $person->deleted_at,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Persons/Create',
            [
                'ressortCategorySelect' => RessortCategory::where('account_id', '=', Auth::user()->account->id)
                    ->orderBy('name')
                    ->get(),
            ]
        );
    }

    public function store()
    {
        Request::validate([
            'name' => ['required'],
            'ressort_category_id' => ['nullable'],
            'phone' => ['required_without:email'],
            'email' => ['required_without:phone'],
            'year' => ['nullable'],
            'registered' => ['nullable'],
            'friday' => ['nullable'],
            'friday_beer' => ['nullable'],
            'saturday' => ['nullable'],
            'saturday_beer' => ['nullable'],
            'sunday' => ['nullable'],
            'sunday_beer' => ['nullable'],
            't_shirt_size' => ['nullable'],
            't_shirt_picked_up' => ['nullable'],
            'food' => ['nullable'],
            'allergies' => ['nullable', 'max:5000'],
            'other' => ['nullable', 'max:5000'],
            'note' => ['nullable', 'max:5000'],
        ]);

        Auth::user()->account->persons()->create([
            'name' => Request::input('name'),
            'ressort_category_id' => Request::input('ressort_category_id'),
            'phone' => Request::input('phone'),
            'email' => Request::input('email'),
            'year' => Request::input('year'),
            'registered' => Request::input('registered'),
            'friday' => Request::input('friday'),
            'friday_beer' => Request::input('friday_beer'),
            'saturday' => Request::input('saturday'),
            'saturday_beer' => Request::input('saturday_beer'),
            'sunday' => Request::input('sunday'),
            'sunday_beer' => Request::input('sunday_beer'),
            't_shirt_size' => Request::input('t_shirt_size'),
            't_shirt_picked_up' => Request::input('t_shirt_picked_up'),
            'food' => Request::input('food'),
            'allergies' => Request::input('allergies'),
            'other' => Request::input('other'),
            'note' => Request::input('note'),
        ]);

        return Redirect::route('persons')->with('success', 'Person erstellt.');
    }

    public function edit(Person $person)
    {
        return Inertia::render('Persons/Edit', [
            'person' => [
                'id' => $person->id,
                'name' => $person->name,
                'ressort_category_id' => $person->ressort_category_id,
                'phone' => $person->phone,
                'email' => $person->email,
                'year' => $person->year,
                'registered' => $person->registered,
                'friday' => $person->friday,
                'friday_beer' => $person->friday_beer,
                'saturday' => $person->saturday,
                'saturday_beer' => $person->saturday_beer,
                'sunday' => $person->sunday,
                'sunday_beer' => $person->sunday_beer,
                't_shirt_size' => $person->t_shirt_size,
                't_shirt_picked_up' => $person->t_shirt_picked_up,
                'food' => $person->food,
                'allergies' => $person->allergies,
                'other' => $person->other,
                'note' => $person->note,
                'deleted_at' => $person->deleted_at,
            ],
            'ressortCategorySelect' => RessortCategory::where('account_id', '=', Auth::user()->account->id)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function update(Person $person)
    {
        $person->update(
            Request::validate([
                'name' => ['required'],
                'ressort_category_id' => ['nullable'],
                'phone' => ['required_without:email'],
                'email' => ['required_without:phone'],
                'year' => ['nullable'],
                'registered' => ['nullable'],
                'friday' => ['nullable'],
                'friday_beer' => ['nullable'],
                'saturday' => ['nullable'],
                'saturday_beer' => ['nullable'],
                'sunday' => ['nullable'],
                'sunday_beer' => ['nullable'],
                't_shirt_size' => ['nullable'],
                't_shirt_picked_up' => ['nullable'],
                'food' => ['nullable'],
                'allergies' => ['nullable', 'max:5000'],
                'other' => ['nullable', 'max:5000'],
                'note' => ['nullable', 'max:5000'],
            ])
        );

        return Redirect::back()->with('success', 'Person aktualisiert.');
    }

    public function destroy(Person $person)
    {
        $person->delete();

        return Redirect::back()->with('success', 'Person gelöscht.');
    }

    public function restore(Person $person)
    {
        $person->restore();

        return Redirect::back()->with('success', 'Person wiederhergestellt.');
    }

    public function searchPersons(RequestHttp $request)
    {
        $ressortWorkShiftId = $request->input('ressortWorkShiftId');
        $searchValue = $request->input('searchValue');

        if ($ressortWorkShiftId) {
            $ressortWorkShift = RessortWorkShift::find($ressortWorkShiftId);
        }

        if (!$ressortWorkShift || $ressortWorkShift->account_id != Auth::user()->account->id) {
            abort(403);
        }

        return Person::select('id', 'name')
            ->where('account_id', '=', Auth::user()->account->id)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->whereDoesntHave('ressortWorkShifts', function ($q) use ($ressortWorkShift) {
                $q->whereIn('ressort_work_shift_id', [$ressortWorkShift->id]);
            })
            ->whereDoesntHave('ressortWorkShifts', function ($q) use ($ressortWorkShift) {
                $q->where('time_start', '=', $ressortWorkShift->time_start)
                    ->where('day', '=', $ressortWorkShift->day);
            })
            ->orderBy('name')
            ->limit(10)
            ->get();
    }


    public function pdfFilters(RequestHttp $request)
    {
        $chips = $request->input('chips');

        $persons = Auth::user()->account
            ->persons()
            ->select('persons.*', 'ressort_categories.name as ressortCategoryName', 'ressort_categories.deleted_at as ressortCategoryDeletedAt')
            ->leftjoin('ressort_categories', 'persons.ressort_category_id', '=', 'ressort_categories.id')
            ->orderBy('persons.name')
            ->filter(Request::only('search', 'year', 'registered', 'friday', 'saturday', 'sunday', 't_shirt_size', 't_shirt_picked_up', 'food', 'allergies', 'note', 'other', 'ressort_category_name'))
            ->get();

        $tshirtCount['XS'] = 0;
        $tshirtCount['S'] = 0;
        $tshirtCount['M'] = 0;
        $tshirtCount['L'] = 0;
        $tshirtCount['XL'] = 0;
        $tshirtCount['2XL'] = 0;
        $tshirtCount['3XL'] = 0;
        $tshirtCount['4XL'] = 0;
        $tshirtCount['5XL'] = 0;

        foreach ($persons as $person) {

            $person->friday = $person->friday === 0 ? 'Nein' : 'Ja';
            $person->saturday = $person->saturday === 0 ? 'Nein' : 'Ja';
            $person->sunday = $person->sunday === 0 ? 'Nein' : 'Ja';

            switch ($person->t_shirt_size) {
                case 'XS':
                    $tshirtCount['XS']++;
                    break;
                case 'S':
                    $tshirtCount['S']++;
                    break;
                case 'M':
                    $tshirtCount['M']++;
                    break;
                case 'L':
                    $tshirtCount['L']++;
                    break;
                case 'XL':
                    $tshirtCount['XL']++;
                    break;
                case '2XL':
                    $tshirtCount['2XL']++;
                    break;
                case '3XL':
                    $tshirtCount['3XL']++;
                    break;
                case '4XL':
                    $tshirtCount['4XL']++;
                    break;
                case '5XL':
                    $tshirtCount['5XL']++;
                    break;
                default:
            }
        }

        $pdf = PDF::loadView('pdf.filter', ['persons' => $persons, 'chips' => $chips, 'tshirtCount' => $tshirtCount])
            ->setPaper('a4', 'landscape');

        $filename = 'Filterliste';
        $dangerousCharacters = array('"', "'", "&", "/", "\\", "?", "#", '<', '>');
        $filename = str_replace($dangerousCharacters, '', $filename);

        return $pdf->stream($filename . '.pdf');
    }


    public function pdfWorkload(Person $person)
    {
        $person->load('ressortWorkShifts.ressort');
        $infos = [];

        if (!sizeof($person->ressortWorkShifts)) {
            abort(404);
        }

        foreach ($person->ressortWorkShifts as $ressortWorkShift) {
            if (!in_array($ressortWorkShift->ressort->info, $infos)) {
                $infos[$ressortWorkShift->ressort->name] = $ressortWorkShift->ressort->info ?? '-';
            }
        }

        $pdf = PDF::loadView('pdf.workload', ['person' => $person, 'infos' => $infos, 'account' => Auth::user()->account]);

        $filename = 'Schichtplan-' . str_replace(' ', '_', $person->name);

        $dangerousCharacters = array('"', "'", "&", "/", "\\", "?", "#", '<', '>');
        $filename = str_replace($dangerousCharacters, '', $filename);

        return $pdf->stream($filename . '.pdf');
    }
}
