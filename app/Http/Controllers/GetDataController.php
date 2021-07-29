<?php
namespace App\Http\Controllers;

use App\Models\Contacts;
use App\Models\Organization;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class GetDataController extends Controller
{
    protected $user;
 
    public function __construct()
    {
        try {
            $this->user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    // list of all organizations
    public function index()
    {
        try {
            return Organization::get();
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    // list of all contact
    public function getContactList(Request $request)
    {
        try {
            return Contacts::get();
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    // list of contact with filter
    public function getContact(Request $request)
    {
        try {
            $search = $request->organization;
            return Contacts::whereHas('organization', function ($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->with(['organization' => function($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%');
            }])->get();
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

    }

    // list of contact with filter
    public function getContactFilters(Request $request)
    {
        try {
            $search = $request->email;
            $verified = $request->is_email_verified;
            $viewContacts = Contacts::where(function ($q) use ($search, $verified) {
                $q->where('email', 'LIKE', '%' . $search . '%')
                    ->where('is_email_verified', $verified);
            })->get();
            return $viewContacts;
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        } 
    }
}