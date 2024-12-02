<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class UserVerify extends Model
{

    use HasFactory;

    public $table = "users_verify";

    public $timestamps = true;

    // Specify the primary key column
    protected $primaryKey = 'token';

    // Disable auto-incrementing, as 'token' is not numeric
    public $incrementing = false;

    // Set the type of the primary key
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}