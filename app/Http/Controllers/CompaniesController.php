<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index(Request $request): View
    {
        $companies = Company::query();

        if (!empty($request->get('search'))) {
            $companies->whereRaw("LOWER(`name`) LIKE ?", ["%" . strtolower($request->get('search')) . "%"]);
        }

        $companies = $companies->orderBy('id', 'desc')->paginate(15);

        return view('companies.list', compact('companies'));
    }

    public function deleteAction($id): JsonResponse
    {
        $company = Company::whereId( (int)$id )->first();

        if ($company instanceof Company) {

            $result = $company->delete();

            return response()->json([
                'status' => (bool)$result,
            ]);
        }

        return response()->json([
            'status' => false,
        ]);
    }
}
