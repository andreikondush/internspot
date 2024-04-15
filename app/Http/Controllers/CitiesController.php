<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Http\Requests\City as CityRequest;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    public function index(Request $request): View
    {
        $cities = City::query();

        if (!empty($request->get('search'))) {
            $cities->whereRaw("LOWER(`name`) LIKE ?", ["%" . strtolower($request->get('search')) . "%"]);
        }


        $cities = $cities->orderBy('id', 'desc')->paginate(15);

        return view('cities.list', compact('cities'));
    }

    public function create(): View
    {
        return view('cities.create');
    }

    public function createAction(CityRequest $request): JsonResponse
    {
        $validated = $request->safe()->only([
            'name',
        ]);

        $city = City::create(['name' => $validated['name']]);

        if ($city instanceof City) {
            return response()->json([
                'redirect' => route('cities.list'),
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => "Failed to add city.",
        ]);
    }

    public function edit($id): View|RedirectResponse
    {
        $city = City::whereId( (int)$id )->first();

        if ($city instanceof City) {
            return view('cities.edit', compact('city'));
        }

        return redirect()->route('cities.list');
    }

    public function editAction(CityRequest $request, $id): JsonResponse|RedirectResponse
    {
        $validated = $request->safe()->only([
            'name',
        ]);

        $city = City::whereId( (int)$id )->first();

        if ($city instanceof City) {

            $city->name = $validated['name'];
            $city->save();

            return response()->json([
                'status' => true,
                'title' => __("Saved!")
            ]);
        }

        return redirect()->route('cities.list');
    }

    public function deleteAction($id): JsonResponse
    {
        $city = City::whereId( (int)$id )->first();

        if ($city instanceof City) {

            $result = $city->delete();

            return response()->json([
                'status' => (bool)$result,
            ]);
        }

        return response()->json([
            'status' => false,
        ]);
    }
}
