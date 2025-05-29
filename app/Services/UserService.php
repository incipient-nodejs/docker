<?php

namespace App\Services;

use App\Util\Auditor;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Util\FileUpload;
use Illuminate\Support\Facades\Redis;
use App\Services\Abs\ServiceCrud;
use App\Interfaces\ICrud;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService implements ICrud
{
    private $userTypeService;

    function __construct(){
        $this->userTypeService = new UserTypeService();
    }

    /** @override */
    public function findAll()
    {
        if (Redis::exists('users:json')) {
            $users = json_decode(Redis::get('users:json'), true);
            return collect($users);

        }
        $users = User::with([
            'formalType',
            'informalType',
            'personalData',
            'companyData',
            'businessDetail'
        ])->where(Auditor::filter())->get();
        Redis::set('users:json', $users);
        return $users;
    }

    /** @override */
    public function paginate()
    {
        return User::with('formalType', 'informalType', 'personalData', 'companyData', 'businessDetail')->where(Auditor::filter())->paginate();
    }

    /** @override */
    public function create(array $data)
    {
        if (filter_var($data['phone'], FILTER_VALIDATE_EMAIL)) {
            $data['email'] = $data['phone'];
            $data['phone'] = null;
        } else {
            $data['phone'] = $data['phone'];
            $data['email'] = null;
        }
        if (Redis::exists('users:json')) {
            Redis::del('users:json');
        }

        if (!isset($data['user_type_id'])) {
            $data['user_type_id'] = $this->userTypeService->findUserTypeDefaultOrCreate()->id;
        }
        $data['concat'] = $data['name'] . ($data['phone'] ?? '');
        if (isset($data['email'])) {
            $data['concat'] .= $data['email'];
        }
        $data['password'] = bcrypt($data['password']);

        return User::create(Auditor::create($data));

    }

    /** @override */
    public function update(array $data, string $id)
    {
        $user = $this->findByIdOrUuid($id);
        $data['concat'] = $data['name'].$data['email'].$data['phone'];
        if(isset($data['email'])) $data['concat'] .= $data['email'];
        $user->update(Auditor::update($data));
        return $user;
    }

    /** @override */
    public function delete(string $id)
    {

        if (Redis::exists('users:json')) {
            Redis::del('users:json');
        }
        $user = $this->findByIdOrUuid($id);
        $user->update(array_merge(Auditor::delete(), [
            'phone' => Auditor::uniqueDelete($user->phone)
        ]));
    }

    public function findByUuid(string $uuid): User
    {
        return User::with('formalType', 'informalType', 'personalData', 'companyData', 'businessDetail')->where(array_merge(['id' => $uuid], Auditor::filter()))->firstOrFail();
    }

    public function findByEmailOrPhone(string $emailOrPhone){
        $user = User::with('formalType', 'informalType', 'personalData', 'companyData', 'businessDetail')
        ->where(function ($query) use ($emailOrPhone) {
            $query->where('phone', $emailOrPhone)
                  ->orWhere('email', $emailOrPhone);
        })->where('status', 'ativo')
        ->where(Auditor::filter())
        ->first();
        if (!$user) {
            throw new NotFoundHttpException('Usuário não encontrado com o email ou telefone informado.');
        }

        return $user;
    }

    public function findByPhone(string $emailOrPhone){
        $queryField = filter_var($emailOrPhone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        return User::with('formalType', 'informalType', 'personalData', 'companyData', 'businessDetail')->where(array_merge([
            $queryField => $emailOrPhone, 'status' => 'ativo'
            ], Auditor::filter()))->firstOrFail();
    }

    public function findByIdOrUuid(string $idOrUuid): User
    {
        $query = User::with('formalType', 'informalType', 'personalData', 'companyData', 'businessDetail')->where(function ($query) use ($idOrUuid) {
            $query->where('uuid', $idOrUuid)->where(Auditor::filter());
        });
        if (is_numeric($idOrUuid)) {
            $query->orWhere('id', $idOrUuid);
        }
        return $query->firstOrFail();
    }

    public function updateMobile($request, array $data, string $id): User
    {
        $user = $this->findByIdOrUuid($id);

        // if(!Hash::check($data['yourPassword'], $user->password)){
        //     throw new \Exception("Passaword do utilizador invalido");
        // }

        // $data['password'] = bcrypt($data['password']);

        FileUpload::uploadImageUser($request, $data);

        if(isset($data['name'])) $data['concat'] = ($data['concat'] ?? '') . $data['name'];
        if(isset($data['phone'])) $data['concat'] = ($data['concat'] ?? '') . $data['phone'];
        if(isset($data['email'])) $data['concat'] = ($data['concat'] ?? '') . $data['email'];
        $user->update(Auditor::update($data));
        return $user;
    }

    public function updatePassword($request, array $data, string $id): User
    {
        $user = $this->findByIdOrUuid($id);

        if (!Hash::check($data['old_password'], $user->password)) {
            throw new \Exception('Invalid password.');
        }

        if($data['yourPassword'] != $data['password']){
            throw new \Exception("Senha diferente");
        }

        $data['password'] = bcrypt($data['password']);
        $user->update(Auditor::update($data));
        return $user;
    }

}
