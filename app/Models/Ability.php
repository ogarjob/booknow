<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    use HasFactory;

    const CREATE_RESERVATIONS  = 1; // TODO
    const EDIT_RESERVATIONS    = 2;
    const DELETE_RESERVATIONS  = 3;
    const EDIT_USERS           = 4;
    const CHANGE_USER_PASSWORD = 5; // TODO
    const DELETE_USERS         = 6;
    const APPROVE_TRANSACTIONS = 7; // TODO
    const DELETE_TRANSACTIONS  = 8; // TODO
}
