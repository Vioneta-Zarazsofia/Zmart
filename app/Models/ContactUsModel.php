<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUsModel extends Model
{
    use HasFactory;
    protected $table = 'contact_us';

    static public function getSingle($id)
    {
        return self::first($id);
    }
    static public function getRecord()
    {
        $return = self::select('contact_us.*');
        if (request('id')) {
            $return = $return->where('contact_us.id', request('id'));
        }
        if (request('name')) {
            $return = $return->where('contact_us.name', 'like', '%' . request('name') . '%');
        }
        if (request('email')) {
            $return = $return->where('contact_us.email', 'like', '%' . request('email') . '%');
        }
        if (request('phone')) {
            $return = $return->where('contact_us.phone', 'like', '%' . request('phone') . '%');
        }
        if (request('subject')) {
            $return = $return->where('contact_us.subject', 'like', '%' . request('subject') . '%');
        }


        $return = $return->orderBy('contact_us.id', 'desc');
        $return = $return->paginate(20);
        return $return;
    }
    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}