<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\PersonRepository;

class EloquentPersonRepository extends EloquentBaseRepository implements PersonRepository
{
    public function getData(array $data)
    {
        $languages = $data['languages'] ?? [];
        if (!is_array($languages)) {
            $languages = [$languages];
        }

        $contact_options = $data['contact_options'] ?? [];
        if (!is_array($contact_options)) {
            $contact_options = [$contact_options];
        }

        $data['languages'] = implode(',', $languages);
        $data['contact_options'] = implode(',', $contact_options);
        return $data;
    }
}
