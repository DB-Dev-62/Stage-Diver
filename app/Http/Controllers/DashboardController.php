<?php

namespace App\Http\Controllers;

use App\Models\RessortWorkShift;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $ressortCategoryTabs = Cache::remember(
            hash(
                'sha256',
                'ressortCategoryTabs'
            ), 30, function () {
            return Auth::user()->account->ressortCategories()->whereHas('ressorts')->orderBy('name')->select('id', 'name')->get();
        });

        // View modus
        $view = Request::input('view');
        if ($view == 2) {
            $view = 2;
        } else {
            $view = 1;
        }

        // Status filter
        $filterStatus = Request::input('status');
        if ($filterStatus == 'open') {
            $filterStatus = 'open';
        } else if ($filterStatus == 'open-with-optional') {
            $filterStatus = 'open-with-optional';
        } else {
            $filterStatus = 'all';
        }

        // Day filter
        $filterDay = Request::input('day');
        if ($filterDay == 'fr') {
            $filterDay = 'fr';
        } else if ($filterDay == 'sa') {
            $filterDay = 'sa';
        } else if ($filterDay == 'so') {
            $filterDay = 'so';
        } else {
            $filterDay = 'all';
        }

        // Active category
        $categoryIds = [];
        $categorySelected = intval(Request::input('tab'));
        $ressortCategoryTabsArr = $ressortCategoryTabs->toArray();
        if (sizeof($ressortCategoryTabsArr)) {
            foreach ($ressortCategoryTabsArr as $ressortCategoryTabValue) {
                $categoryIds[] = $ressortCategoryTabValue['id'] ?? null;
            }
        }
        // Fallback default
        if (!in_array($categorySelected, $categoryIds)) {
            $categorySelected = $categoryIds[0] ?? 0;
        }

        // Days
        $days = Cache::remember(
            hash(
                'sha256',
                'days.' . $categorySelected . '.' . $filterDay
            ), 30, function () use ($categorySelected, $filterDay) {
            $query = Auth::user()->account->ressortWorkShifts()->select('day')
                ->whereHas('ressort', function ($q) use ($categorySelected) {
                    $q->where('ressort_category_id', '=', $categorySelected);
                });
            // Filter
            if ($filterDay != 'all') {
                $query->where('day', '=', strtoupper($filterDay));
            }
            return $query->orderByRaw("CASE
                        WHEN day = 'MO' THEN 'Z'
                        ELSE day
                        END asc")
                ->distinct()->pluck('day')->toArray();
        });

        $ressortCategoriesPerDay = [];

        $ressorts = Cache::remember(
            hash(
                'sha256',
                'resorts.' . $categorySelected
            ), 30, function () use ($categorySelected) {
            return Auth::user()->account->ressorts()->where('ressort_category_id', '=', $categorySelected)->get();
        });

        switch ($view) {
            case 1:
                // Every category
                foreach ($ressortCategoryTabs as $ressortCategory) {
                    // Only selected category
                    if ($ressortCategory->id === $categorySelected) {
                        // Every day
                        foreach ($days as $day) {
                            // Every ressort
                            foreach ($ressortCategory->ressorts as $ressort) {
                                $ressortWorkShifts = RessortWorkShift::with('persons.ressortWorkShifts.ressort')->where('day', '=', $day)->where('ressort_id', '=', $ressort->id)->orderBy('time_start')->orderBy('time_end')->get();
                                if ($filterStatus === 'open') {
                                    foreach ($ressortWorkShifts as $key => $ressortWorkShift) {
                                        if (
                                            $ressortWorkShift->persons()->where('is_optional', '=', 0)->count() == $ressortWorkShift->supporter_min
                                        ) {
                                            unset($ressortWorkShifts[$key]);
                                        }
                                    }
                                } else if ($filterStatus === 'open-with-optional') {
                                    foreach ($ressortWorkShifts as $key => $ressortWorkShift) {
                                        $optionalPersons = $ressortWorkShift->supporter_max - $ressortWorkShift->supporter_min;

                                        if ($ressortWorkShift->persons()->where('is_optional', '=', 1)->count() == $optionalPersons &&
                                            $ressortWorkShift->persons()->where('is_optional', '=', 0)->count() == $ressortWorkShift->supporter_min
                                        ) {
                                            unset($ressortWorkShifts[$key]);
                                        }
                                    }
                                }
                                if (sizeof($ressortWorkShifts)) {
                                    $ressortCategoriesPerDay[$ressortCategory->id][$day][$ressort->name] = $ressortWorkShifts;
                                }
                            }
                        }
                    }
                }
                break;
            case 2:
                // Every category
                foreach ($ressortCategoryTabs as $ressortCategory) {
                    // Only selected category
                    if ($ressortCategory->id === $categorySelected) {
                        // Every ressort
                        foreach ($ressortCategory->ressorts as $ressort) {
                            // Every day
                            foreach ($days as $day) {
                                $ressortWorkShifts = RessortWorkShift::with('persons.ressortWorkShifts.ressort')->where('day', '=', $day)->where('ressort_id', '=', $ressort->id)->orderBy('time_start')->orderBy('time_end')->get();
                                if ($filterStatus === 'open') {
                                    foreach ($ressortWorkShifts as $key => $ressortWorkShift) {
                                        if (
                                            $ressortWorkShift->persons()->where('is_optional', '=', 0)->count() == $ressortWorkShift->supporter_min
                                        ) {
                                            unset($ressortWorkShifts[$key]);
                                        }
                                    }
                                } else if ($filterStatus === 'open-with-optional') {
                                    foreach ($ressortWorkShifts as $key => $ressortWorkShift) {
                                        $optionalPersons = $ressortWorkShift->supporter_max - $ressortWorkShift->supporter_min;

                                        if ($ressortWorkShift->persons()->where('is_optional', '=', 1)->count() == $optionalPersons &&
                                            $ressortWorkShift->persons()->where('is_optional', '=', 0)->count() == $ressortWorkShift->supporter_min
                                        ) {
                                            unset($ressortWorkShifts[$key]);
                                        }
                                    }
                                }
                                if (sizeof($ressortWorkShifts)) {
                                    $ressortCategoriesPerDay[$ressortCategory->id][$ressort->name][$day] = $ressortWorkShifts;
                                }
                            }
                        }
                    }
                }
                break;
        }

        return Inertia::render('Dashboard/Index', [
            'ressortCategoryTabs' => $ressortCategoryTabs,
            'ressortCategories' => $ressortCategoriesPerDay,
            'ressorts' => $ressorts,
            'days' => $days,
            'selectedView' => $view,
            'selectedStatus' => $filterStatus,
            'selectedDay' => $filterDay,
            'selectedTab' => $categorySelected,
        ]);
    }
}
