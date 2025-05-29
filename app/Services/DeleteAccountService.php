<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\DeleteAccount;
use App\Models\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log as LaravelLog;
use App\Interfaces\ICrud;
use Illuminate\Support\Facades\Hash;

class DeleteAccountService implements ICrud
{
    private $userService;

    function __construct(){
        $this->userService =  new UserService();
    }

    /** @override */
    public function findAll()
    {
        $deleteAccounts = DeleteAccount::all();
        return $deleteAccounts;
    }

    /** @override */
    public function paginate()
    {
        $paginatedData = DeleteAccount::paginate();
        return $paginatedData;
    }

    /** @override */
    public function create(array $data)
    {
        try {
            $user = $this->userService->findByIdOrUuid($data['user_id']);

            if (!Hash::check($data['password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid password.',
                ], 401);
            }

            $data['name'] = $user->name;
            $data['phone'] = $user->phone;
            $data['send_data'] = now();
            $deleteAccount = DeleteAccount::updateOrCreate(['user_id' => $data['user_id']], $data);
            return $deleteAccount;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function update(array $data, string $id)
    {
        try {
            $deleteAccount = $this->findById($id);
            $deleteAccount->update($data);
            return $deleteAccount;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /** @override */
    public function delete(string $id)
    {
        try {
            $deleteAccount = $this->findById($id);
            $deleteAccount->delete();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function findById(string $idOrUuid): DeleteAccount
    {
        try {
            $deleteAccount = DeleteAccount::findOrFail($idOrUuid);
            return $deleteAccount;
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }
}
