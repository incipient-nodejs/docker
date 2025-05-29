<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Favorito;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const TABLE = "users";

    protected $table = User::TABLE;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'user_type_id',
        'address',
        'name',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'image',
        'type',
        'concat',
        'role',
        'status',
        'category',
        'created_by',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function services(){
        return $this->hasMany(Service::class);
    }

    public function apiEndpoints(){
        return $this->hasMany(ApiEndpoint::class);
    }

    public function formalType(){
        return $this->hasOne(FormalType::class);
    }

    public function informalType(){
        return $this->hasOne(InformalType::class);
    }

    public function personalData(){
        return $this->hasOne(PersonalData::class);
    }

    public function companyData(){
        return $this->hasOne(CompanyData::class);
    }

    public function businessDetail(){
        return $this->hasOne(BusinessDetail::class);
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }

    

}
