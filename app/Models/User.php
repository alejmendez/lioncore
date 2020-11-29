<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;
use Musonza\Chat\Traits\Messageable;

class User extends Authenticatable implements JWTSubject, Auditable
{
    use Notifiable, \OwenIt\Auditing\Auditable, HasRoles, SoftDeletes, Messageable;

    public $incrementing = false;

    protected $keyType = 'string';
    protected $with = ['person'];

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'person_id', 'username', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    public function person()
    {
        return $this->belongsTo('App\Models\Person');
    }

    public function getFullNameAttribute()
    {
        return "{$this->person->first_name} {$this->person->last_name}";
    }

    public function getAllInformation()
    {
        $role = $this->roles->first();
        $permissions = $role->getAllPermissions()->map(function ($permission) {
            return $permission->name;
        });
        return [
            'id'              => $this->id,
            'uid'             => $this->id,
            'displayName'     => $this->getFullNameAttribute(),
            'about'           => $this->person->about,
            'photoURL'        => $this->person->avatar,
            'userRole'        => $role->name,
            'userPermissions' => $permissions,
            'username'        => $this->username,
            'status'          => $this->status,
            'person_id'       => $this->person->id,
            'dni'             => $this->person->dni,
            'first_name'      => $this->person->first_name,
            'last_name'       => $this->person->last_name,
            'full_name'       => $this->getFullNameAttribute(),
            'company'         => $this->person->company,
            'avatar'          => $this->person->avatar,
            'birthdate'       => $this->person->birthdate,
            'room_telephone'  => $this->person->room_telephone,
            'mobile_phone'    => $this->person->mobile_phone,
            'website'         => $this->person->website,
            'languages'       => $this->person->languages,
            'email'           => $this->person->email,
            'nationality'     => $this->person->nationality,
            'gender'          => $this->person->gender,
            'civil_status'    => $this->person->civil_status,
            'contact_options' => $this->person->contact_options,
            'address'         => $this->person->address,
            'address2'        => $this->person->address2,
            'postcode'        => $this->person->postcode,
            'city'            => $this->person->city,
            'state'           => $this->person->state,
            'country'         => $this->person->country,
            'number_children' => $this->person->number_children,
            'observation'     => $this->person->observation,
            'blood_type'      => $this->person->blood_type,
        ];
    }

    public function getParticipantDetailsAttribute()
    {
        return [
            'name' => $this->full_name,
            'foo' => 'bar',
        ];
    }
}


