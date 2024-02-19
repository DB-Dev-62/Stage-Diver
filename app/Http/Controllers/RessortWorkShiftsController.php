<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Ressort;
use App\Models\RessortWorkShift;
use Illuminate\Http\Request as RequestHttp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class RessortWorkShiftsController extends Controller
{
    public function index(Ressort $ressort)
    {
        if ($ressort->account_id != Auth::user()->account->id) {
            abort(403);
        }

        return Inertia::render('RessortWorkShifts/Index', [
            'filters' => Request::all('search', 'trashed'),

            'ressortWorkShiftSelect' => Ressort::where('account_id', '=', Auth::user()->account->id)
                ->orderBy('name')
                ->get(),
            'ressort' => $ressort,
            'ressortWorkShifts' => $ressort->ressortWorkShifts()
                ->orderByRaw("CASE
                        WHEN day = 'MO' THEN 'Z'
                        ELSE day
                        END asc")
                ->orderBy('time_start')
                ->orderBy('time_end')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(100)
                ->withQueryString()
                ->through(fn($ressortWorkShift) => [
                    'id' => $ressortWorkShift->id,
                    'ressort_id' => $ressortWorkShift->ressort_id,
                    'ressort_name' => $ressortWorkShift->ressort->name,
                    'day' => $ressortWorkShift->day,
                    'time_start' => $ressortWorkShift->time_start,
                    'time_end' => $ressortWorkShift->time_end,
                    'supporter_min' => $ressortWorkShift->supporter_min,
                    'supporter_max' => $ressortWorkShift->supporter_max,
                ]),
        ]);
    }


    public function create(Ressort $ressort)
    {
        if ($ressort->account_id != Auth::user()->account->id) {
            abort(403);
        }

        return Inertia::render('RessortWorkShifts/Create',
            [
                'ressort' => $ressort,
                'ressortSelect' => Ressort::where('account_id', '=', Auth::user()->account->id)
                    ->orderBy('name')
                    ->get(),
            ]);
    }


    public function store(RequestHttp $request, Ressort $ressort)
    {
        if ($ressort->account_id != Auth::user()->account->id) {
            abort(403);
        }

        $request->merge([
            'ressort_id' => $ressort->id,
        ]);

        Request::validate([
            'ressort_id' => ['required'],
            'day' => ['required'],
            'time_start' => ['required', 'integer', 'min:0', 'max:24'],
            'time_end' => ['required', 'integer', 'min:0', 'max:24'],
            'supporter_min' => ['required', 'integer', 'min:1', 'max:999'],
            'supporter_max' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        if (Request::input('time_start') > Request::input('time_end')) {
            $validator = Validator::make([], []);
            $validator->errors()->add('time_start', 'Dieses Feld muss kleiner als das Feld "Ende" sein.');
            throw new ValidationException($validator);
        }

        Auth::user()->account->ressortWorkShifts()->create([
            'ressort_id' => Request::input('ressort_id'),
            'day' => Request::input('day'),
            'time_start' => Request::input('time_start'),
            'time_end' => Request::input('time_end'),
            'supporter_min' => Request::input('supporter_min'),
            'supporter_max' => Request::input('supporter_max'),
        ]);

        return Redirect::route('ressort-work-shifts', $ressort->id)->with('success', 'Schichtzeit erstellt.');
    }


    public function edit(Ressort $ressort, RessortWorkShift $ressortWorkShift)
    {
        if ($ressort->account_id != Auth::user()->account->id || $ressortWorkShift->account_id != Auth::user()->account->id) {
            abort(403);
        }

        return Inertia::render('RessortWorkShifts/Edit', [
            'ressort' => $ressort,
            'ressortWorkShift' => [
                'id' => $ressortWorkShift->id,
                'day' => $ressortWorkShift->day,
                'time_start' => $ressortWorkShift->time_start,
                'time_end' => $ressortWorkShift->time_end,
                'supporter_min' => $ressortWorkShift->supporter_min,
                'supporter_max' => $ressortWorkShift->supporter_max,
                'ressort_id' => $ressortWorkShift->ressort_id,
                'ressort_name' => $ressortWorkShift->ressort ? $ressortWorkShift->ressort->name : null,
            ]
        ]);
    }


    public function update(RequestHttp $request, Ressort $ressort, RessortWorkShift $ressortWorkShift)
    {
        if ($ressort->account_id != Auth::user()->account->id || $ressortWorkShift->account_id != Auth::user()->account->id) {
            abort(403);
        }

        $request->merge([
            'ressort_id' => $ressort->id,
        ]);

        Request::validate([
            'ressort_id' => ['required'],
            'day' => ['required'],
            'time_start' => ['required', 'integer', 'min:0', 'max:24'],
            'time_end' => ['required', 'integer', 'min:0', 'max:24'],
            'supporter_min' => ['required', 'integer', 'min:1', 'max:999'],
            'supporter_max' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        if (Request::input('time_start') > Request::input('time_end')) {
            $validator = Validator::make([], []);
            $validator->errors()->add('time_start', 'Dieses Feld muss kleiner als das Feld "Ende" sein.');
            throw new ValidationException($validator);
        }

        // Validate linked persons
        $optional = Request::input('supporter_max') - Request::input('supporter_min');
        $required = Request::input('supporter_min');
        $optionalLinked = $ressortWorkShift->persons()->where('is_optional', '=', 1)->count();
        $requiredLinked = $ressortWorkShift->persons()->where('is_optional', '=', 0)->count();
        // Optional
        if ($optional < $optionalLinked) {
            $validator = Validator::make([], []);
            if ($optionalLinked == 1) {
                $validator->errors()->add('supporter_max', 'Es ist bereits ein optionaler Helfer verknüpft.');
            } else {
                $validator->errors()->add('supporter_max', 'Es sind bereits ' . $optionalLinked . ' optionale Helfer verknüpft.');
            }
            throw new ValidationException($validator);
        }
        // Required
        if ($required < $requiredLinked) {
            $validator = Validator::make([], []);
            if ($requiredLinked == 1) {
                $validator->errors()->add('supporter_min', 'Es ist bereits ein Helfer verknüpft.');
            } else {
                $validator->errors()->add('supporter_min', 'Es sind bereits ' . $requiredLinked . ' Helfer verknüpft.');
            }
            throw new ValidationException($validator);
        }

        $ressortWorkShift->update(
            [
                'day' => Request::input('day'),
                'time_start' => Request::input('time_start'),
                'time_end' => Request::input('time_end'),
                'supporter_min' => Request::input('supporter_min'),
                'supporter_max' => Request::input('supporter_max'),
            ]
        );

        return Redirect::back()->with('success', 'RessortWorkShifts aktualisiert.');
    }


    public function destroy(Ressort $ressort, RessortWorkShift $ressortWorkShift)
    {
        if ($ressort->account_id != Auth::user()->account->id || $ressortWorkShift->account_id != Auth::user()->account->id) {
            abort(403);
        }

        $ressortWorkShift->delete();

        return Redirect::route('ressort-work-shifts', $ressort->id)->with('success', 'Schichtzeit gelöscht.');
    }


    public function restore(Ressort $ressort, RessortWorkShift $ressortWorkShift)
    {
        if ($ressort->account_id != Auth::user()->account->id || $ressortWorkShift->account_id != Auth::user()->account->id) {
            abort(403);
        }

        $ressortWorkShift->restore();

        return Redirect::route('ressort-work-shifts', $ressort->id)->with('success', 'Schichtzeit wiederhergestellt.');
    }

    public function addPerson(RequestHttp $request, Ressort $ressort, RessortWorkShift $ressortWorkShift)
    {
        if ($ressort->account_id != Auth::user()->account->id || $ressortWorkShift->account_id != Auth::user()->account->id) {
            abort(403);
        }

        $personId = $request->input('person');
        $isOptional = $request->input('isOptional') ?? 0;

        if ($personId) {
            $person = Person::where('id', '=', $personId)->where('account_id', '=', Auth::user()->account->id)->first();

            if ($person) {

                if ($isOptional) {
                    $optionalPersons = $ressortWorkShift->supporter_max - $ressortWorkShift->supporter_min;

                    if ($ressortWorkShift->persons()->where('is_optional', '=', 1)->count() >= $optionalPersons) {
                        return ['success' => false];
                    }
                } else {
                    if ($ressortWorkShift->persons()->where('is_optional', '=', 0)->count() >= $ressortWorkShift->supporter_min) {
                        return ['success' => false];
                    }
                }

                $ressortWorkShift->persons()->syncWithoutDetaching([$person->id => ['is_optional' => $isOptional]]);

                return ['success' => true];
            }
        }

        return ['success' => false];
    }

    public function deletePerson(RequestHttp $request, Ressort $ressort, RessortWorkShift $ressortWorkShift)
    {
        if ($ressort->account_id != Auth::user()->account->id || $ressortWorkShift->account_id != Auth::user()->account->id) {
            abort(403);
        }

        $personId = $request->input('person');

        if ($personId) {
            $person = Person::where('id', '=', $personId)->where('account_id', '=', Auth::user()->account->id)->first();

            if ($person) {
                $ressortWorkShift->persons()->detach($person->id);

                return ['success' => true];
            }
        }

        return ['success' => false];
    }

    public function getPersons(Ressort $ressort, RessortWorkShift $ressortWorkShift)
    {
        if ($ressort->account_id != Auth::user()->account->id || $ressortWorkShift->account_id != Auth::user()->account->id) {
            abort(403);
        }

        $personsArr = [];

        if ($ressortWorkShift) {
            $persons = $ressortWorkShift->persons;
            $persons->load('ressortWorkShifts.ressort');

            foreach ($persons as $person) {
                $personsArr[] = [
                    'id' => $person->id,
                    'name' => $person->name,
                    'workload' => $person->workload,
                    'is_optional' => $person->is_optional,
                    'ressort_work_shifts' => $person->ressortWorkShifts
                ];
            }
        }

        return $personsArr;
    }
}
