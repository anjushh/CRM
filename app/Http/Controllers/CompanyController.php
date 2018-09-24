<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Validator;
use DB;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $create_records= Company::latest()->paginate(10);
        return view('company.create',compact('create_records'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = ($request["status"] == "on") ? 1 : 0;
        $inputs = $request->all();
        $rules = array(
                    'company_name' => 'required|distinct',
                    'company_address' => 'required',
                    'company_email' => 'required|distinct',
                    'company_contact' => 'required',
                    'company_gst' => 'required',
                    'company_pan' => 'required',
                    'company_logo' => 'required',
                    'status' => 'required'
                );
        $valids = Validator::make($inputs, $rules);
        $company_name = $request->company_name;
        $company_email = $request->company_email;

        if($valids->fails()){
            return redirect()->route('company.create')->withErrors($valids)->withInput();
        }
        else {
            if($status == 1)
            {
                $all_status = DB::table('companies')->get();
                foreach ($all_status as $statu) {
                    Company::where('id', $statu->id)->update(['status' => 0]);
                }
                
            }
            if($request->hasFile('company_logo')){
                $file = $request->file('company_logo');
                $filename = $file->getClientOriginalName();
                $fileExtension = $file->getClientOriginalExtension();
                $name = str_slug($request->filename).'.'.$file->getClientOriginalExtension();
                $path = $request->company_logo->storeAs('company-logo',$filename,'public');
            }
            else {
                return 'No File';
            }
            if (Company::where([ ["company_name", "=", $company_name ]])->exists()) {
                return redirect()->route('company.create')->with('message','Company Name has a duplicate Value');
            }
            if (Company::where([ ["company_email", "=", $company_email ]])->exists()) {
                return redirect()->route('company.create')->with('message','Company Email has a duplicate Value');
            }
            $data = $request->all();
            $data['company_logo'] = $path;
            $data['status'] = $status;
            Company::create($data);
            return redirect()->route('company.create')->with('success','Data Submitted Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
     public function edit(Request $request, $id)
    {
        $edit_records = (new Company)->edit($id);
        $create_records= Company::latest()->paginate(10);
        return view('company.create',compact('create_records','edit_records'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $status = ($request['status'] == "on") ? 1 : 0;
        $inputs = $request->all();
        $rules = array(
            'company_name' => 'required',
            'company_address' => 'required',
            'company_email' => 'required',
            'company_contact' => 'required',
            'company_gst' => 'required',
            'company_pan' => 'required',
            'company_logo' => 'required',
            'status' => 'required'
        );
        $valids = Validator::make($inputs, $rules);

        if($valids->fails()){
            return redirect()->route('company.create')->withErrors($valids)->withInput();
        }
        else {
            if($status == 1)
            {
                $all_status = DB::table('companies')->get();
                foreach ($all_status as $statu) {
                    Company::where('id', $statu->id)->update(['status' => 0]);
                }
            }
            if($request->hasFile('company_logo')){
                $file = $request->file('company_logo');
                $filename = $file->getClientOriginalName();
                $fileExtension = $file->getClientOriginalExtension();
                $name = str_slug($request->filename).'.'.$file->getClientOriginalExtension();
                $path = $request->company_logo->storeAs('company-logo',$filename,'public');
                
            }
            else {
                return 'No File';
            }
            $data = $request->all();
            $data['company_logo'] = $path;
            $data['status'] = $status;
            Company::find($id)->update($data);
            $create_records= Company::latest()->paginate(10);
            return view('company.create',compact('create_records'))->with('i', ($request->input('page', 1) - 1) * 10);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
