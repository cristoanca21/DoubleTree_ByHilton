<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Habitacion;
use App\Models\TipoHabitacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ────────────────────────────────────────────
        Cliente::firstOrCreate(
            ['email' => 'admin@doubletree.com'],
            [
                'nombre'       => 'Admin',
                'apellido'     => 'DoubleTree',
                'password'     => Hash::make('Admin2024!'),
                'dni'          => '00000000',
                'nacionalidad' => 'Peruana',
                'rol'          => 'admin',
            ]
            );

        // ── Tipos de habitación ───────────────────────────────
        $matrimonial = TipoHabitacion::firstOrCreate(
            ['nombre' => 'Matrimonial'],
            ['descripcion' => 'Cama King size, vista a la ciudad o al mar, baño privado y minibar.', 'precio_noche' => 150.00, 'capacidad' => 2]
        );

        $doble = TipoHabitacion::firstOrCreate(
            ['nombre' => 'Doble'],
            ['descripcion' => 'Dos camas dobles, ideal para familias o viajeros de negocios.', 'precio_noche' => 220.00, 'capacidad' => 3]
        );

        $suite = TipoHabitacion::firstOrCreate(
            ['nombre' => 'Suite'],
            ['descripcion' => 'Suite de lujo con sala de estar, jacuzzi y vista panorámica 360°.', 'precio_noche' => 300.00, 'capacidad' => 4]
        );

        // ── Habitaciones: 70 Mat + 57 Dob + 20 Suite = 147 ───
        // Solo crea si no hay habitaciones
        if (Habitacion::count() === 0) {
            for ($piso = 1; $piso <= 10; $piso++) {
                for ($n = 1; $n <= 7; $n++) {
                    Habitacion::create([
                        'tipo_id' => $matrimonial->id,
                        'numero' => $piso.str_pad($n, 2, '0', STR_PAD_LEFT),
                        'piso' => $piso,
                        'estado' => 'disponible',
                    ]);
                }
                for ($n = 8; $n <= 10; $n++) {
                    Habitacion::create([
                        'tipo_id' => $doble->id,
                        'numero' => $piso.str_pad($n, 2, '0', STR_PAD_LEFT),
                        'piso' => $piso,
                        'estado' => 'disponible',
                    ]);
                }
            }

            for ($piso = 11; $piso <= 13; $piso++) {
                for ($n = 1; $n <= 9; $n++) {
                    Habitacion::create([
                        'tipo_id' => $doble->id,
                        'numero' => $piso.str_pad($n, 2, '0', STR_PAD_LEFT),
                        'piso' => $piso,
                        'estado' => 'disponible',
                    ]);
                }
            }

            for ($n = 1; $n <= 20; $n++) {
                    Habitacion::create([
                        'tipo_id' => $suite->id,
                        'numero' => '14'.str_pad($n, 2, '0', STR_PAD_LEFT),
                        'piso' => 14,
                        'estado' => 'disponible',
                    ]);
                }
            }

            $this->command->info('✅ Seeder completado: 1 admin + 3 tipos + 147 habitaciones');
        }
    }
