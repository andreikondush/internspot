<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Company;
use App\Models\Internship;
use App\Models\Tag;
use App\Services\CompanyService;
use App\Services\InternshipService;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use Illuminate\View\View;
use App\Http\Requests\Internship as InternshipRequest;

class InternshipsController extends Controller
{
    /**
     * TagService
     *
     * @var TagService
     */
    protected TagService $tagService;

    /**
     * Company service
     *
     * @var CompanyService
     */
    protected CompanyService $companyService;

    /**
     * InternshipService
     *
     * @var InternshipService
     */
    protected InternshipService $internshipService;

    /**
     * @param TagService $tagService
     * @param CompanyService $companyService
     * @param InternshipService $internshipService
     */
    public function __construct(TagService $tagService, CompanyService $companyService, InternshipService $internshipService)
    {
        $this->tagService = $tagService;
        $this->companyService = $companyService;
        $this->internshipService = $internshipService;
    }

    public function index(Request $request): View
    {
        $internships = $this->internshipService->getFilteredInternships($request);

        $cities = City::all();
        $companies = Company::all();
        $tags = Tag::all();

        return view('internships.list', compact('internships', 'cities', 'companies', 'tags'));
    }

    public function show($id): View|RedirectResponse
    {
        $internship = Internship::whereId( (int)$id )->first();

        if ($internship instanceof Internship) {
            return view('internships.show', compact('internship'));
        }

        return redirect()->route('internships.list');
    }

    public function create(): View|RedirectResponse
    {
        if ($this->isAdmin()) {
            return redirect()->route('internships.list');
        }

        $cities = City::all();
        $companies = Company::all();

        return view('internships.create', compact('cities', 'companies'));
    }

    public function createAction(InternshipRequest $request): JsonResponse|RedirectResponse
    {
        if ($this->isAdmin()) {
            return redirect()->route('internships.list');
        }

        $validated = $request->safe()->only([
            'title', 'description', 'address',
            'city', 'company_name', 'company_email',
            'tags'
        ]);

        $company = Company::updateOrCreate(
            ['name' => $validated['company_name']],
            ['email' => $validated['company_email']]
        );

        $internship = Internship::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'city_id' => $validated['city'],
            'company_id' => $company->id,
            'user_id' => auth('user')->user()->id,
        ]);

        if ($internship instanceof Internship) {

            // Deletes all companies without internships
            $this->companyService->deleteCompaniesWithoutInternships();

            $internship->tags()->sync( $this->tagService->updateOrCreateTags($validated['tags']) );

            $this->tagService->deleteTagsWithoutInternships();

            return response()->json([
                'redirect' => route('internships.show', ['id' => $internship->id]),
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => "Failed to create city internship.",
        ]);
    }

    public function edit($id): View|RedirectResponse
    {
        $internship = Internship::whereId( (int)$id )->whereHas('user', function ($query) {
            $query->where('id', auth('user')->user()->id);
        })->first();

        if ($internship instanceof Internship) {

            $cities = City::all();
            $companies = Company::all();

            return view('internships.edit', compact('internship', 'cities', 'companies'));
        }

        return redirect()->route('internships.list');
    }

    public function editAction(InternshipRequest $request, $id): JsonResponse|RedirectResponse
    {
        $validated = $request->safe()->only([
            'title', 'description', 'address',
            'city', 'company_name', 'company_email',
            'tags'
        ]);

        $internship = Internship::whereId( (int)$id )->whereHas('user', function ($query) {
            $query->where('id', auth('user')->user()->id);
        })->first();

        if ($internship instanceof Internship) {

            $company = Company::updateOrCreate(
                ['name' => $validated['company_name']],
                ['email' => $validated['company_email']]
            );

            $internship->title = $validated['title'];
            $internship->description = $validated['description'];
            $internship->address = $validated['address'];
            $internship->city_id = $validated['city'];
            $internship->company_id = $company->id;
            $internship->save();

            // Deletes all companies without internships
            $this->companyService->deleteCompaniesWithoutInternships();

            $internship->tags()->sync( $this->tagService->updateOrCreateTags($validated['tags']) );

            $this->tagService->deleteTagsWithoutInternships();

            return response()->json([
                'status' => true,
                'title' => __("Saved!")
            ]);
        }

        return redirect()->route('internships.list');
    }

    public function deleteAction($id): JsonResponse
    {
        $internship = Internship::whereId( (int)$id )->whereHas('user', function ($query) {
            if (!$this->isAdmin()) {
                $query->where('id', auth('user')->user()->id);
            }
        })->first();

        if ($internship instanceof Internship) {

            $result = $internship->delete();

            $this->companyService->deleteCompaniesWithoutInternships();
            $this->tagService->deleteTagsWithoutInternships();

            return response()->json([
                'status' => (bool)$result,
            ]);
        }

        return response()->json([
            'status' => false,
        ]);
    }
}
