<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Client;

class ClientController extends Controller
{
    // Create company 
    public function createClient(Request $request){
    	try{
    		$inputs = $request->all();
			
			$validator = ( new Company )->validateCompany( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $name = $inputs['company_name'];
            $check = (new Company)->where('company_name', '=', $name)->first();

            if (count($check) >= 1) {
                $message = array('Company' => 'Company Details already exist in our records');
                return apiResponseApp(false, 406, "",  $message);
            }

            if ($inputs['status'] == 1) {
                $all_companies = Company::get();
                foreach ($all_companies as $company) {
                    Company::where('id', $company->id)->update(['status' => 0]);
                }
            }

            $company_logo = rand(100000, 999999);

            $request->file('company_logo')->move(public_path().'/uploads/company_logo/', $company_logo);
            unset($inputs['company_logo']);
            $inputs = $inputs + ['company_logo' => $company_logo];
            $id = (new Company)->store($inputs);
            return apiResponseApp(true, 200, lang('Company created successfully'));


    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

     // Create company 
    public function editCompany(Request $request){
    	try{
    		$inputs = $request->all();
			
			$validator = ( new Company )->validateCompanyEdit( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }

            $id = $inputs['id'];


            if (isset($inputs['company_name'])) {
            	$name = $inputs['company_name'];
	            $check = (new Company)->where('company_name', '=', $name)->where('id', '!=', $id)->first();

	            if (count($check) >= 1) {
	                $message = array('Company' => 'Company Details by name '. $name. ' already exist in our records');
	                return apiResponseApp(false, 406, "",  $message);
	            }
            }

            if ($inputs['status'] == 1) {
                $all_companies = Company::get();
                foreach ($all_companies as $company) {
                    Company::where('id', $company->id)->update(['status' => 0]);
                }
            }

            if (isset($inputs['company_logo'])) {
                $company_logo = rand(100000, 999999);
                $request->file('company_logo')->move(public_path().'/uploads/company_logo/', $company_logo);
                unset($inputs['company_logo']);
                $inputs = $inputs + ['company_logo' => $company_logo];
            }

            $id = (new Company)->store($inputs, $id);
            return apiResponseApp(true, 200, lang('Company updated successfully'));


    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }

     //Delete Company
    public function deleteCompany(Request $request){
        try{
            $inputs = $request->all();
            
            $validator = ( new Company )->validateCompanyEdit( $inputs );
            if( $validator->fails() ) {
                return apiResponseApp(false, 406, "", errorMessages($validator->messages()));
            }
            $id = $inputs['id'];
            $inputs['status'] = 0;
            $user_profile = (new Company)->deleteAccount($id);
            return apiResponseApp(true, 200, 'Company record successfully deleted');


        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }

     //Company List
    public function companyList(){
        try{            
            $user_profile = Company::get();
            return apiResponseApp(true, 200, null, [], $user_profile);


        }catch(Exception $e){
            return apiResponseApp(false, 500, lang('messages.server_error'));
        }
    }
}
