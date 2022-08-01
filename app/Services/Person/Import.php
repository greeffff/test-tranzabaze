<?php


namespace App\Services\Person;


use App\Models\Classifiers\SdnType;
use App\Services\Person\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\DB;

class Import
{
    protected $url;
    protected $status;
    const EMPTY = 'empty';
    const UPDATING = 'updating';
    const SUCCESS = 'success';

    public function __construct(Status $status)
    {
        $this->status = $status;
    }

    public function update($url)
    {
        $xml = $this->readXml($url);
        $this->status->setStatus(self::UPDATING);
        try {
            DB::beginTransaction();
            foreach ($xml as $record) {
                if (!is_null($record->uid)) {
                    Person::updateOrCreate(['uid' => get_object_vars($record->uid)[0]], [
                        'uid' => get_object_vars($record->uid)[0],
                        'name' => get_object_vars($record->lastName)[0],
                        'sdn_type_id' => $this->getType(get_object_vars($record->sdnType)[0]),
                        'data' => json_encode($record->akaList)
                    ]);
                }
            }
            DB::commit();
            $this->status->setStatus(self::SUCCESS);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['result' => false, 'info' => 'service unavailable', 'code' => 503], 503);
        }
        return response()->json(['result' => true, 'info' => '', 'code' => 200]);
    }

    private function readXml($url)
    {
        $request = new Request();
        $xml = $request->get($url);
        $xml = simplexml_load_string($xml);
        return $xml->sdnEntry;
    }

    private function getType($type)
    {
        $result = SdnType::updateOrCreate(['name' => $type], ['name' => $type]);
        return $result->id;
    }

}
