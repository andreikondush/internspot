<?php

namespace App\Http\Controllers;

use App\Http\Requests\Feedback as FeedbackRequest;
use App\Models\Feedback;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use function Symfony\Component\String\b;

class FeedbacksController extends Controller
{
    public function createAction(FeedbackRequest $request): JsonResponse|RedirectResponse
    {
        if ($this->isAdmin()) {
            return redirect()->route('internships.list');
        }

        $validated = $request->safe()->only([
            'internship_id', 'text', 'score',
        ]);

        $feedback = Feedback::create([
            'user_id' => auth('user')->user()->id,
            'internship_id' => $validated['internship_id'],
            'text' => $validated['text'],
            'score' => $validated['score'],
        ]);

        if ($feedback instanceof Feedback) {
            return response()->json([
                'status' => true,
                'title' => "Successfully added.",
                'update' => true,
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => "Failed to add feedback to internship.",
        ]);
    }

    public function editAction(FeedbackRequest $request, $id): JsonResponse|RedirectResponse
    {
        $feedback = Feedback::whereId( (int)$id )->whereHas('user', function ($query) {
            $query->where('id', auth('user')->user()->id);
        })->first();

        if ($feedback instanceof Feedback) {

            $validated = $request->safe()->only([
                'text', 'score',
            ]);

            $feedback->text = $validated['text'];
            $feedback->score = $validated['score'];
            $feedback->save();

            return response()->json([
                'status' => true,
                'title' => __("Saved!")
            ]);
        }

        return redirect()->route('internships.list');
    }

    public function deleteAction($id): JsonResponse
    {
        $feedback = Feedback::whereId( (int)$id )->whereHas('user', function ($query) {
            if (!$this->isAdmin()) {
                $query->where('id', auth('user')->user()->id);
            }
        })->first();

        if ($feedback instanceof Feedback) {

            $result = $feedback->delete();

            return response()->json([
                'status' => (bool)$result,
            ]);
        }

        return response()->json([
            'status' => false,
        ]);
    }
}
