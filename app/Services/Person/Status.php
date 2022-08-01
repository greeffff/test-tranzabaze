<?php


namespace App\Services\Person;


use App\Models\Person;

class Status implements \App\Services\Interfaces\Status
{

    private $currentStatus;
    private $response;
    private $model;

    public function __construct()
    {
        $this->model = Person::class;
    }

    public function setStatus($newVal)
    {
        try {
            \App\Models\Status::create([
                'model' => $this->model,
                'state' => $newVal,
            ]);
            $this->currentStatus = $newVal;
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function getStatus()
    {
        try {
            $this->currentStatus = \App\Models\Status::where('model', $this->model)->latest()->first();
            call_user_func(array($this, $this->currentStatus->state));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
            return false;
        }
        return $this->response;
    }

    private function empty()
    {
        $this->response = response()->json(['result' => false, 'info'=> 'empty']);
    }

    private function updating()
    {
        $this->response = response()->json(['result' => false, 'info'=> 'updating']);
    }

    private function success()
    {
        $this->response = response()->json(['result' => true, 'info'=> 'ok']);
    }

}
