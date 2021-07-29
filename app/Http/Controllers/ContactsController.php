<?php

namespace App\Http\Controllers;
use App\Models\Organization;
use App\Models\Contacts;
use App\Models\VerifyContact;
use Illuminate\Http\Request;
use App\Mail\VerifyMail;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // get contacts data with filter
        $search = $request->search;
        try {
            $viewContacts = Contacts::getContactData($request);
            $columns = [
                'first_name' => 'First Name',
                'last_name' => 'Last Name',
                'mobile_numbers' => 'Mobile numbers',
                'email' => 'Email',
                'organization_id' => 'Organization',
                'dob' => 'Date of Birth',
                'action' => 'Action'
            ];
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        
        return view('contacts/index')->with(
            [
                'viewContacts' => $viewContacts,
                'columns' => $columns,
                'search' => $search
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // create new contact view 
        try {
            $organizationList = Organization::get();
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return view('contacts/addEdit')->with(['organizationList' => $organizationList]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // store contact and validate
        try {
            $this->validateForm($request);

            // check if contact already created then update contact
            if ($request->id) {
                $contacts = Contacts::where('id', '=', $request->id)->first();
                $msg = "Contact updated successfully.";
            } else {
                $contacts = new Contacts;
                $msg = "Contact added successfully.";
            }
        
            $contacts->first_name = $request->first_name;
            $contacts->last_name = $request->last_name;
            $contacts->mobile_numbers = json_encode($request->mobile_numbers);
            $contacts->organization_id = $request->organization_id;
            $contacts->dob = $request->dob;
            $contacts->email = $request->email;
            $contacts->save();

            // send mail if first time contact created
            if (!$request->id) {
                $verifyContact = new VerifyContact;
                $verifyContact->contact_id = $contacts->id;
                $verifyContact->token = sha1(time());
                $verifyContact->save();
                \Mail::to($request->email)->send(new VerifyMail($contacts));
            }
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect()->route('contact')->with('msg', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // contact data display view
        try {
            $organizationList = Organization::get();
            $viewContact = Contacts::find($id);
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return view('contacts/view')->with(['viewContact' => $viewContact,'organizationList' => $organizationList]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // edit contact view
        try {
            $organizationList = Organization::get();
            $viewContact = Contacts::find($id);
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return view('contacts/addEdit')->with(['viewContact' => $viewContact,'organizationList' => $organizationList]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // contact delete 
        try {
            $deleteContacts = Contacts::find($id)->delete();
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect()->route('contact')->with('msg', "Contact deleted successfully.");
    }

    // verification contact
    public function verifyUser($token)
    {
        try {
            // verify user on click on mail verification link
            $contact = VerifyContact::where('token', $token)->first();
            $verifyUser = Contacts::where('id', $contact->contact_id)->first();
            $verifyUser->is_email_verified = 1;
            $verifyUser->save();
            $status = "Your e-mail is verified.";
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect('/contact')->with('msg', $status);
    }

    //Form validation for contact
    public function validateForm(Request $request)
    {
        $messages = [
            "first_name.required" => "Please enter first name",
            "first_name.max" => "The first name entered exceeds the maximum length ",
            "last_name.required" => "Please enter last name",
            "last_name.max" => "The last name entered exceeds the maximum length ",
            "email.email" => "Please enter valid email address",
            "organization_id.required" => "Please select organization",
            "organization_id.not_in" => "Please select organization",
            "dob.required" => "Please select birthdate",
        ];

        $validateAtt = $request->validate([
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'email' => 'required|email|regex:^\w+@[a-zA-Z_]+?\.[a-zA-Z.]{2,20}$^|unique:contacts,email,'. $request->id,
            'organization_id' => 'required|not_in:0',
            'dob' => 'required|before:today',
            ],$messages);

        return $validateAtt;
    }
}
