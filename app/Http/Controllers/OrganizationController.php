<?php

namespace App\Http\Controllers;
use App\Models\Categories;
use App\Models\Organization;
use App\Models\Contacts;
use Storage;

use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // List all organizations
        try {
            $viewOrganization = Organization::getOrganizationData();
            $columns = [
                'logo' => 'Logo',
                'name' => 'Name',
                'category_id' => 'Category',
                'trade_license' => 'Trade License',
                'licensed_date' => 'Licensed Date',
                'action' => 'Action'
            ];
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return view('organization/index')->with(
            [
                'viewOrganization' => $viewOrganization,
                'columns' => $columns,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // create organization view
        try {
            $categoryList = Categories::get();
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return view('organization/addEdit')->with(['categoryList' => $categoryList]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate organization data and store
        try {
            $this->validateForm($request);

            // check if organization already created then update
            if ($request->id) {
                $organization = Organization::where('id', '=', $request->id)->first();
                $msg = "Organization updated successfully.";
            } else {
                $organization = new Organization;
                $msg = "Organization added successfully.";
            }
        
            $organization->name = $request->name;
            $organization->category_id = $request->category_id;
            $organization->trade_license = $request->trade_license;
            $organization->licensed_date = $request->licensed_date;

            // store logo image in storage folder
            if ($request->hasFile('logo')) {
                if ($organization->logo) {
                    Storage::delete('public/upload/organization/images/' . $organization->logo);
                }
                $file = $request->file('logo');
                $name = explode('.', $file->getClientOriginalName())[0];
                $extension = explode('.', $file->getClientOriginalName())[1];
                $fileName = $name . time() . '.' . $extension;
                Storage::disk('local')->put('public/upload/organization/images/' . $fileName, file_get_contents($file->getRealPath()));
                $organization->logo = $fileName;
            }

            $organization->save();
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('organizations')->with('msg', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // created view for show data
        try {
            $categoryList = Categories::get();
            $viewOrganization = Organization::find($id);
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return view('organization/view')->with(['viewOrganization' => $viewOrganization,'categoryList' => $categoryList]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //  created view for edit
        try {
            $categoryList = Categories::get();
            $viewOrganization = Organization::find($id);
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return view('organization/addEdit')->with(['viewOrganization' => $viewOrganization,'categoryList' => $categoryList]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            Contacts::where('organization_id',$id)->delete();
            // delete organization data
            $delete = Organization::find($id)->delete();
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect()->route('contact')->with('msg', "Organization deleted successfully.");
    }

    //Form validation for organization
    public function validateForm(Request $request)
    {
        $messages = [
            "name.required" => "Please enter name",
            "name.max" => "The first name entered exceeds the maximum length ",
            "trade_license.required" => "Please enter trade license",
            "category_id.required" => "Please select category",
            "category_id.not_in" => "Please select category",
            "licensed_date.required" => "Please select licensed date",
            "logo.dimensions" => "Logo must be 1000*1000",
        ];

        $validateAtt = $request->validate([
            'name' => 'required|max:191|unique:organizations,name,'. $request->id,
            'trade_license' => 'required',
            'category_id' => 'required|not_in:0',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif|dimensions:max_width=1000,max_height=1000',
            'licensed_date' => 'required|before:today',
        ],$messages);

        return $validateAtt;
    }
}
