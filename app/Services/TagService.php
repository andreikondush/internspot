<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class TagService
{
    /**
     * Deletes all tags without internships.
     *
     * This method finds all tags that do not have associated internships,
     * and deletes them from the database.
     *
     * @return void
     */
    public function deleteTagsWithoutInternships(): void
    {
        // Find all tags without internships
        $tagsWithoutInternships = DB::table('tags')
            ->leftJoin('internship_tags', 'internship_tags.tag_id', '=', 'tags.id')
            ->leftJoin('internships', 'internship_tags.internship_id', '=', 'internships.id')
            ->whereNull('internships.company_id')
            ->select('tags.id')
            ->get();


        // Delete the found tags
        foreach ($tagsWithoutInternships as $tag) {
            Tag::whereId($tag->id)->delete();
        }
    }


    /**
     * Update or create Tags
     *
     * @param array $tagNames
     *
     * @return array ids
     */
    public function updateOrCreateTags(array $tagNames): array
    {
        $result = [];

        foreach ($tagNames as $tagName) {

            $tag = Tag::updateOrCreate(['name' => $tagName]);

            if ($tag instanceof Tag) {
                $result[] = $tag->id;
            }
        }

        return $result;
    }
}
