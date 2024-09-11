<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KVM extends Model
{
    use HasFactory;
    protected $table = "kvms";
    protected $fillable = [
        "kvm_id", "kvm_name", "signature", "valid_until","api_host"
    ];
}
