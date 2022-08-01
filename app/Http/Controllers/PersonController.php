<?php

namespace App\Http\Controllers;

use App\Filters\PersonFilter;
use App\Models\Person;
use App\Services\Person\Import;
use App\Services\Person\PersonEloquent;
use App\Services\Person\Status;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    protected $personService;
    protected $status;
    private $url = 'https://www.treasury.gov/ofac/downloads/sdn.xml';

    public function __construct(Import $personService, Status $status)
    {
        $this->personService = $personService;
        $this->status = $status;
    }

    public function getName(Request $request)
    {
        $filter = new PersonFilter($request);
        $filter = $filter->apply(Person::query());
        $eloqFilter = new PersonEloquent($filter);
        $filtred = $eloqFilter->type($request->get('type'));
        dd($filtred);
    }

    public function update()
    {
        return $this->personService->update($this->url);
    }

    public function state()
    {
        return $this->status->getStatus();
    }

}
