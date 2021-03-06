<?php

namespace App\Http\Controllers;

use App\Companies;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompaniesController extends Controller
{
    /**
     *
     *
     * @author norbi
     *
     */
    public static function listCompanies(){

        if(cp(10, Auth::user()->getPermissionIds())) {
            $companies = Companies::all();
            return view('companies/index', compact('companies'));
        } else {
            return abort(403, 'Http/Controllers/CompaniesController.php:24');
        }


    }

    /**
     *
     *
     * @author norbi
     *
     */
    public static function companyProfile($id){

        if(cp(12, Auth::user()->getPermissionIds())) {
            $company = Companies::find($id);
            $company->users = $company->userList();

            $action = '/companies/profile';
            return view('companies/profile', compact('company', 'action'));
        } else {
            abort(403);
        }

    }

    public static function saveCompany($request){

        $company = Companies::find($request->id);
        $company->name = $request->name;
        $company->short_name = $request->short_name;
        $company->tax = $request->tax;
        $company->address = $request->address;
        $company->save();

        return redirect()->back();

    }




    public static function newCompanyView(){
        $company = new Collection();
        $company->name = "";
        $company->short_name = "";
        $company->tax = '';
        $company->address = "";
        $company->id = '';

        $action = '/companies/new';
        return view('companies.profile', compact('company', 'action'));
    }

    public static function newCompany($request){
//        dd($request->all());

        $data = $request->all();
        unset($data->id);

        Companies::create($data);
        return redirect('/companies');
    }


}
