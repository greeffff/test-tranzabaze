<?php


namespace App\Filters;


use Illuminate\Database\Eloquent\Builder;

class PersonFilter extends QueryFilter
{
    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->filters() as $name => $value) {
            if (!method_exists($this, $name)) {
                continue;
            }
            if (strlen($value)) {
                if ($name == 'name') {
                    $this->$name($value, $this->filters()['type']);
                } else {
                    $this->$name($value);
                }
            } else {
                $this->$name();
            }
        }
        return $this->builder;
    }

    public function name($val)
    {
        return $this->builder->where("data->aka->0->lastName", 'like', '%' . $val . '%')
            ->orWhere("data->aka->0->lastName", 'like', '%' . $val . '%')
            ->orWhere("data->aka->0->firstName", 'like', '%' . $val . '%')
            ->orWhere("data->aka->0->firstName", 'like', '%' . $val . '%');
    }

//    public function type($val)
//    {
//        $result = $this->builder->get();
//        $result = $result->map(function ($row) use ($val) {
//            $row->data = json_decode($row->data);
//            $row->data->aka = collect($row->data->aka);
//            $categories = $row->data->aka->where('category',$val);
//            if(count($categories)) {
//                $filtred = collect();
//                $filtred->uui = $row->uid;
//                $filtred->data = $row->data->aka->where('category', $val);
//                return $filtred;
//            }
//            return null;
//        });
//        return $result->filter(function ($value) { return !is_null($value); });
//    }

}
