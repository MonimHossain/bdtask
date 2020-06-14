<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Employee;

class ProcessController extends Controller
{
    
    public function insert(Request $request){
        if($request){
            if($validatedData = $request->validate([
                'name' => ['required'],
                'email' => ['unique:employee,email,'.$request['email']],
                'salary' => ['required'],
            ])){
                $model = new Employee;
                $model->name = $request['name'];
                $model->email = $request['email'];
                $model->salary = $request['salary'];
                
                $hourlySalaryRate = $request['salary'] / 184; //consider 4 days friday and 
                                                              // 3 days holiday total days 23, 8 hours 
                                                              // in a day the month would be 23*8 = 184.
                
                $providentFundPerMonth = ($request['salary'] * .03);
                $hourlyProvidentFund = $providentFundPerMonth /184;

                $medicalFundPerMonth = (5000 / 2) / 12;
                $hourlyMedicalFund = $medicalFundPerMonth / 184;

                $hourlyTotalDecution = $hourlySalaryRate - ($hourlyProvidentFund + $hourlyMedicalFund);
                
                $revenueSharing = ((20000000 * .05) / 50) / 12;
                $hourlyRevenueSharing = $revenueSharing / 184;
                
                $expectedTotalHourly =  $hourlyTotalDecution + $hourlyRevenueSharing;

                $expectedSalary = $expectedTotalHourly * 207;   //consider 4 days friday and 
                                                                // 3 days holiday total days 23, 9 hours 
                                                                // in a day the month would be 23*9 = 207.

                $model->expected_earning = $expectedSalary;

                if($model->save()){
                    return redirect()->action(
                        'ProcessController@index'
                    );
                }
            }
        }
        
    }

    public function index(){
        $data = Employee::all();
        return view('user.profile',compact('data'));
    }

    public function create(){
        return view('user.create');
    }
}