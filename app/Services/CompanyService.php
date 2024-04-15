<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    /**
     * Deletes all companies without internships.
     *
     * This method finds all companies that do not have associated internships,
     * and deletes them from the database.
     *
     * @return void
     */
    public function deleteCompaniesWithoutInternships(): void
    {
        // Find all companies without internships
        $companiesWithoutInternships = DB::table('companies')
            ->leftJoin('internships', 'companies.id', '=', 'internships.company_id')
            ->whereNull('internships.company_id')
            ->select('companies.id')
            ->get();

        // Delete the found companies
        foreach ($companiesWithoutInternships as $company) {
            Company::whereId($company->id)->delete();
        }
    }
}
