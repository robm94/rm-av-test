<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiToken extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'token',
        'expires_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }

    /**
     * Find token by token value
     *
     * @param string $token
     * @return static|null
     */
    public static function findByToken(string $token): ?static
    {
        return static::where('token', hash('sha256', $token))->first();
    }
    
    /**
     * Create a API access token
     *
     * @return static
     */
    public static function generateToken(): string
    {
        $tokenValue = Str::random(60);
        $token = ApiToken::create([
            'token' => hash('sha256', $tokenValue),
            'expires_at' => now()->addHours(2),
        ]);

        return $tokenValue;
    }
}
