<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\Country;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use \Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Transformers\CityTransformer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Interfaces\ICityRepository;

class CityController extends BaseAPIController
{
    protected $manager;
    protected $cityTransformer;
    protected $cityRepository;
    protected $model;
    public function __construct(
        City $model,
        Manager $manager,
        ICityRepository $cityRepository,
        CityTransformer $cityTransformer)
    {
        $this->model = $model;
        $this->manager = $manager;
        $this->cityRepository = $cityRepository;
        $this->cityTransformer = $cityTransformer;
        $this->setTransformer($cityTransformer);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cities = City::orderBy('country_id', 'asc');
        if(isset($request['country_id'])){
            $cities = $cities->where('country_id', $request['country_id']);
        }
        return $this->responseCollection($cities->get(), 200, [], ['paginate' => false]);
        // $countries = config('countries');
        // return response()->json($countries, 200);
        // $cities = config('cities'); //new Collection(config('cities'));
        // $district = new Collection(config('districts'));
        // $wards = new Collection(config('wards'));  //collect(config('districts'));
        // $id = 0;
        // $newDis = [];
        // $newWard = [];
        // foreach($cities as $key=>$city){
        //     //$cities[$key]['id'] = ++$id;
        //     //unset($cities[$key]['id']);
        //     $i = ++$id;
        //     $cities[$key]['country_id'] = 3;
        //     $d = $district->where('city_id', $cities[$key]['id'])->map(function ($item, $key) use($i) {
        //         return array_merge($item, ['city_id' => $i]);
        //     });
        //     array_push($newDis, ...$d);
        // }
        // // foreach($newDis as $key=>$value){
        // //     //$cities[$key]['id'] = ++$id;
        // //     //unset($cities[$key]['id']);
        // //     $newDis[$key]['id'] = $key + 1;
        // // }
        // foreach($newDis as $key=>$value){
        //     //unset($newDis[$key]['id']);
        //     $name = $newDis[$key]['name'];
        //     $d = $wards->where('district_id', $newDis[$key]['id'])->map(function ($item, $k) use($key, $name) {
        //         return array_merge($item, ['district_id' => $key + 1]);
        //     });
        //     array_push($newWard, ...$d);
        // }

        // Storage::disk('public')->put('images.json', json_encode($newWard, JSON_UNESCAPED_UNICODE));
        // return "success";
        // return response()->json($newDis, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if (!array_key_exists('country_code', $data) ||
            $data['country_code'] == null ||
            !array_key_exists('name', $data) ||
            $data['name'] == null ||
            !array_key_exists('country_id', $data) ||
            $data['country_id'] === null
        ) {
            return $this->errorsResponse(['error' => trans("Không để trống thông tin.")], 422);
        }
        $checkCountry = Country::find($data['country_id']);
        if(empty($checkCountry)){
            return $this->errorsResponse(['country_id' => trans("ID Quốc gia không tồn tại.")], 422);
        }
        try {
            $entry = $this->cityRepository->create($data);
            return $this->responseOne($entry);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entry = $this->cityRepository->find($id);
        if( empty($entry)){
            return $this->errorsResponse(['id' => trans("ID Tỉnh/Thành phố không tồn tại.")], 404);
        }
        try {
            return $this->responseOne($entry);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $entry = $this->cityRepository->find($id);
        if( empty($entry)){
            return $this->errorsResponse(['id' => trans("ID Tỉnh/Thành phố không tồn tại.")], 404);
        }
        $data = $request->all();
        if (!array_key_exists('country_code', $data) ||
            $data['country_code'] == null ||
            !array_key_exists('name', $data) ||
            $data['name'] == null ||
            !array_key_exists('country_id', $data) ||
            $data['country_id'] === null
        ) {
            return $this->errorsResponse(['error' => trans("Không để trống thông tin.")], 422);
        }
        $checkCountry = Country::find($data['country_id']);
        if(empty($checkCountry)){
            return $this->errorsResponse(['country_id' => trans("ID Quốc gia không tồn tại.")], 422);
        }
        try {
            $entry = $this->cityRepository->update($id, $data);
            return $this->responseOne($entry);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entry = $this->cityRepository
                ->findWithRelationships($id, ['districts']);
        if( empty($entry)){
            return $this->errorsResponse(['id' => trans("ID Tỉnh/Thành phố không tồn tại.")], 404);
        }
        try {
            if($entry->districts->count() != 0){
                return $this->errorsResponse(['id' => trans("Không thể xóa vì đã phát sinh dữ liệu liên quan.")], 404);
            }
            $this->cityRepository->destroy($id);
            return $this->responseOne($entry);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getAll(Request $request, $id)
    {
        $entry = Country::find($id);
        if( !$entry){
            return $this->errorsResponse(['id' => trans("ID Quốc Gia không tồn tại.")], 404);
        }
        $cities = $this->model->getData($request, $id)->get();
        return $this->responseCollection($cities, 200, [], ['paginate' => false]);
    }
}
