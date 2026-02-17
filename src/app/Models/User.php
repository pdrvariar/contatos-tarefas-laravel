<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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

    // Relacionamento: usuário tem muitos contatos
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    // Relacionamento: usuário tem muitas tarefas
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    // Relacionamento: usuário tem muitas tags
    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    // Verifica se é admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
