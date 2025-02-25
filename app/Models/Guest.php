<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Guest",
 *     type="object",
 *     required={"first_name", "last_name"},
 *     @OA\Property(property="id", type="integer", description="Guest ID"),
 *     @OA\Property(property="first_name", type="string", description="First name of the guest"),
 *     @OA\Property(property="last_name", type="string", description="Last name of the guest"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Guest extends Model
{
    /** @use HasFactory<\Database\Factories\GuestFactory> */
    use HasFactory;

    protected $fillable = [
        'last_name',
        'first_name'
    ];
}
