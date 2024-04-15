<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Internship;

class InternshipService
{
    public function getFilteredInternships(Request $request)
    {
        $internships = Internship::leftJoin('feedbacks', 'feedbacks.internship_id', '=', 'internships.id')
            ->selectRaw('internships.id as id, AVG(feedbacks.score) as score, COUNT(feedbacks.score) as quantity_reviews')
            ->groupBy('internships.id');

        $this->applySorting($internships, $request);
        $this->applyFilters($internships, $request);

        $internships = $internships->paginate(15);

        foreach ($internships as $internship) {
            $internship->refresh();
        }

        return $internships;
    }

    private function applySorting($internships, Request $request)
    {
        if ($request->get('sort_by_score') === 'desc') {
            $internships->orderByRaw('score DESC');
        }

        if ($request->get('sort_by_score') === 'asc') {
            $internships->orderByRaw('score ASC');
        }

        if ($request->get('sort_by_feedbacks') === 'desc') {
            $internships->orderByRaw('quantity_reviews DESC');
        }

        if ($request->get('sort_by_feedbacks') === 'asc') {
            $internships->orderByRaw('quantity_reviews ASC');
        }

        $internships->orderBy('id', 'DESC');

        if ($request->get('sort_by_date') === 'desc') {
            $internships->orderBy('created_at', 'DESC');
        }

        if ($request->get('sort_by_date') === 'asc') {
            $internships->orderBy('created_at', 'ASC');
        }
    }

    private function applyFilters($internships, Request $request)
    {
        if (!empty($request->get('search'))) {
            $internships->whereRaw("LOWER(`title`) LIKE ?", ["%" . strtolower($request->get('search')) . "%"]);
        }

        if (!empty($request->get('city'))) {
            $internships->where('city_id', (int)$request->get('city'));
        }

        if (!empty($request->get('company'))) {
            $internships->where('company_id', (int)$request->get('company'));
        }

        if (!empty($request->get('tags'))) {
            $internships->whereHas('tags', function ($query) use ($request) {
                foreach ($request->get('tags') as $tagId) {
                    $query->where('tags.id', $tagId);
                }
            });
        }
    }
}
