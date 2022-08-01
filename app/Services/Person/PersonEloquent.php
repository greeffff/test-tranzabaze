<?php


namespace App\Services\Person;


class PersonEloquent
{

    protected $builder;

    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    public function type($val)
    {
        $result = $this->builder->get();
        $result = $result->map(function ($row) use ($val) {
            $row->data = json_decode($row->data);
            $row->data->aka = collect($row->data->aka);
            $categories = $row->data->aka->where('category', $val);
            if (count($categories)) {
                $filtred = collect();
                $filtred->uui = $row->uid;
                $filtred->data = $row->data->aka->where('category', $val);
                return $filtred;
            }
            return null;
        });
        return $result->filter(function ($value) {
            return !is_null($value);
        });
    }

}
