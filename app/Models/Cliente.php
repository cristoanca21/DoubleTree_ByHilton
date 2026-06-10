<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use Notifiable;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre', 'apellido', 'email', 'password', 'tipo_documento',
        'dni', 'nacionalidad', 'rol',

    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['password' => 'hashed'];

    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'cliente_id');
    }

    public function esAdmin(): bool
    {
        return $this->rol === 'admin';
    }
}
