<?php

namespace App\Http\Controllers\Api;

use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use App\Transformers\DistrictTransformer;
use App\Repositories\Interfaces\IDistrictRepository;

class DistrictController extends BaseAPIController
{
    protected $manager;
    protected $districtTransformer;
    protected $districtRepository;
    public function __construct(
        Manager $manager,
        IDistrictRepository $districtRepository,
        DistrictTransformer $districtTransformer)
    {
        $this->manager = $manager;
        $this->districtRepository = $districtRepository;
        $this->districtTransformer = $districtTransformer;
        $this->setTransformer($districtTransformer);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $districts = District::orderBy('city_id', 'asc');
        if(isset($request['city_id'])){
            $districts = $districts->where('city_id', $request['city_id']);
        }
        return $this->responseCollection($districts->get(), 200, [], ['paginate' => false]);


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
        if (!array_key_exists('name', $data) || $data['name'] == null ||
            !array_key_exists('city_id', $data) || $data['city_id'] === null) {
            return $this->errorsResponse(['error' => trans("Không để trống thông tin.")], 422);
        }
        $checkCity = City::find($data['city_id']);
        if(empty($checkCity)){
            return $this->errorsResponse(['district_id' => trans("ID Tỉnh/Thành phố không tồn tại.")], 422);
        }
        try {
            $entry = $this->districtRepository->create($data);
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
        $entry = $this->districtRepository->find($id);
        if( empty($entry)){
            return $this->errorsResponse(['id' => trans("ID Quận/Huyện không tồn tại.")], 404);
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
        $entry = $this->districtRepository->find($id);
        if( empty($entry)){
            return $this->errorsResponse(['id' => trans("ID Quận/Huyện không tồn tại.")], 404);
        }
        $data = $request->all();
        if (!array_key_exists('name', $data) || $data['name'] == null ||
            !array_key_exists('city_id', $data) || $data['city_id'] === null) {
            return $this->errorsResponse(['error' => trans("Không để trống thông tin.")], 422);
        }
        $checkCity = City::find($data['city_id']);
        if(empty($checkCity)){
            return $this->errorsResponse(['district_id' => trans("ID Tỉnh/Thành phố không tồn tại.")], 422);
        }
        try {
            $entry = $this->districtRepository->update($id, $data);
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
        $entry = $this->districtRepository->findWithRelationships($id,['wards']);
        if( empty($entry)){
            return $this->errorsResponse(['id' => trans("ID Quận/Huyện không tồn tại.")], 404);
        }
        try {
            if($entry->wards->count() != 0){
                return $this->errorsResponse(['id' => trans("Không thể xóa vì đã phát sinh dữ liệu liên quan.")], 404);
            }
            $this->districtRepository->destroy($id);
            return $this->responseOne($entry);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getAll()
    {
        $districts = District::orderBy('city_id', 'asc')->get();
        return $this->responseCollection($districts, 200, [], ['paginate' => false]);
    }
}
