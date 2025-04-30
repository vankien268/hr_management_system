<?php

namespace App\Http\Controllers\Api;

use App\Models\Ward;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\WardTransformer;
use App\Http\Controllers\Api\BaseAPIController;
use App\Models\District;
use App\Repositories\Interfaces\IWardRepository;

class WardController extends BaseAPIController
{
    protected $manager;
    protected $wardTransformer;
    protected $wardRepository;
    public function __construct(
        Manager $manager,
        IWardRepository $wardRepository,
        WardTransformer $wardTransformer)
    {
        $this->manager = $manager;
        $this->wardRepository = $wardRepository;
        $this->wardTransformer = $wardTransformer;
        $this->setTransformer($wardTransformer);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $wards = Ward::orderBy('district_id', 'asc');
        if(isset($request['district_id'])){
            $wards = $wards->where('district_id', $request['district_id']);
        }
        return $this->responseCollection($wards->get(), 200, [], ['paginate' => false]);
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
            !array_key_exists('prefix', $data) || $data['prefix'] == null ||
            !array_key_exists('district_id', $data) || $data['district_id'] === null) {
            return $this->errorsResponse(['error' => trans("Không để trống thông tin.")], 422);
        }
        $checkDistrict = District::find($data['district_id']);
        if(empty($checkDistrict)){
            return $this->errorsResponse(['district_id' => trans("ID Quận/Huyện không tồn tại.")], 422);
        }
        try {
            $entry = $this->wardRepository->create($data);
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
        $entry = $this->wardRepository->find($id);
        if( empty($entry)){
            return $this->errorsResponse(['id' => trans("ID Phường/Xã không tồn tại")], 404);
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
        $entry = $this->wardRepository->find($id);
        if( empty($entry)){
            return $this->errorsResponse(['id' => trans("ID Phường/Xã không tồn tại")], 404);
        }
        $data = $request->all();
        if (!array_key_exists('name', $data) || $data['name'] == null ||
            !array_key_exists('prefix', $data) || $data['prefix'] == null ||
            !array_key_exists('district_id', $data) || $data['district_id'] === null) {
            return $this->errorsResponse(['error' => trans("Không để trống thông tin.")], 422);
        }
        $checkDistrict = District::find($data['district_id']);
        if(empty($checkDistrict)){
            return $this->errorsResponse(['district_id' => trans("ID Quận/Huyện không tồn tại.")], 422);
        }
        try {
            $entry = $this->wardRepository->update($id, $data);
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
        $entry = $this->wardRepository->find($id);
        if( empty($entry)){
            return $this->errorsResponse(['id' => trans("ID Phường/Xã không tồn tại")], 404);
        }
        try {
            $this->wardRepository->destroy($id);
            return $this->responseOne($entry);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getAll()
    {
        $wards = Ward::orderBy('district_id', 'asc')->get();
        return $this->responseCollection($wards, 200, [], ['paginate' => false]);
    }
}
