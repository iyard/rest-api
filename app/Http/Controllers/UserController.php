<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * @var UserService
     */
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        $lastName = $request->input('last_name');
        $phoneNumber = $request->input('phone_namber');
        $email = $request->input('email');

        $users  = User::filterByNameAndLastName($name, $lastName)
            ->filterByPhoneNumber($phoneNumber)
            ->filterByEmail($email)
            ->paginate();

        return UserResource::collection($users);
    }

    /**
     * Validate rules
     *
     * @return array|string[]
     */
    private function getRules(): array
    {
        return [
            'name' => 'required|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            "phones"    => "required|array|min:1",
            "phones.*"  => "required|string|distinct|min:3",
            "emails"    => "required|array|min:1",
            "emails.*"  => "required|email|distinct|min:3",
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, $this->getRules());

        if ($validator->fails()) {
            return response()->json([
                'success' => 'false',
                'errors' => $validator->errors()
            ], 404);
        }
        $this->service->store($requestData);

        return response()->json([
            'success' => 'success',
            'errors' => []
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return UserResource
     */
    public function show($id)
    {
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, $this->getRules());

        if ($validator->fails()) {
            return response()->json([
                'success' => 'false',
                'errors' => $validator->errors()
            ], 404);
        }

        $this->service->update($id, $requestData);

        return response()->json([
                'success' => 'success',
                'errors' => []
            ], 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => 'success',
            'errors' => []
        ], 204);
    }
}
