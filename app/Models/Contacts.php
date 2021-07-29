<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'first_name',
        'last_name',
        'mobile_numbers',
        'email',
        'organization_id',
        'dob',
        'is_email_verified'
    ];

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization','organization_id');
    }

    // fetch contact data using filter
    public static function getContactData($request)
    {   
        $search = $request->search;
        if ($search) {
                $request->session()->put('searchValue',  $search);
        } else {
            $sessionSearch = $request->session()->get('searchValue');
            if($request->get('search') || $request->get('page') || $request->get('role_id')){
                $search = ($sessionSearch)? $sessionSearch : '';
            } else{
                $request->session()->forget('searchValue');
                $search  = '';
            }
        }

        $viewContacts = Contacts::where(function ($q) use ($search) {
            $q->where('email', 'LIKE', '%' . $search . '%')
                ->orWhere('mobile_numbers', 'LIKE', '%' . $search . '%');
        })->with('organization')
        ->paginate(10);

        return $viewContacts;
    }
}
