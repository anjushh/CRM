<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;

class CompanyController extends Controller
{
    // Create company 
    public function createCompany(Request $request){
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

            $company_logo = rand(100000, 999999);

            $request->file('company_logo')->move(public_path().'/uploads/company_logo/', $company_logo);
            unset($inputs['comany_logo']);
            $inputs = $inputs + ['comany_logo' => $company_logo];
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

            $id = (new Company)->store($inputs, $id);
            return apiResponseApp(true, 200, lang('Company updated successfully'));


    	}catch(Exception $e){
			return apiResponseApp(false, 500, lang('messages.server_error'));
    	}
    }
}