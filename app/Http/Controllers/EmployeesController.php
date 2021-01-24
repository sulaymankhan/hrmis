<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Http\Requests\EmployeeRequest;

class EmployeesController extends Controller
{
    public function index(Request $r)
    {
        $searchQuery = $r->input('q');
        $employees = Employee::orderBy('name', 'desc');
        if ($searchQuery) {
            $employees = Employee::where(function ($query) use ($searchQuery) {
                $query->orWhere('id_number', $searchQuery);
                $query->orWhere('employees.name', 'like', '%' . $searchQuery . '%');
                $query->orWhere('surname', $searchQuery);
                $query->orWhere('father_name', $searchQuery);
                $query->orWhere('contact_number', 'like', '%' . $searchQuery, '%');
            });
        }

        if ($r->user()->role == 'center_manager') {
            $employees = $employees->where('center_id', $r->user()->center_id);
            return $employees->take(200)->get();
        }

        return $employees->with('post')->selectRaw(
            'employees.*,centers.name as center_name'
        )->leftJoin('centers', 'center_id', 'centers.id')->take(200)->get();
    }

    public function store(EmployeeRequest $r)
    {
        $idDetails = [
            'volume' => $r->input('id_details.volume', ''),
            'year' => $r->input('id_details.year', ''),
            'page' => $r->input('id_details.page', ''),
            'registeration' => $r->input('id_details.registration', ''),
            'sokok' => $r->input('id_details.sokok', ''),
            'nid_no' => $r->input('id_details.nid_no')
        ];
        $employee                        = new Employee;
        $employee->setId();
        $employee->name                  = $r->input('name');
        $employee->center_id             = $r->input('center_id');
        $employee->surname               = $r->input('surname');
        $employee->father_name           = $r->input('father_name');
        $employee->grand_father_name     = $r->input('grand_father_name', '-');
        $employee->dob                   = $r->input('dob');
        $employee->gender                = $r->input('gender');
        $employee->marital_status        = $r->input('marital_status');
        $employee->contact_number        = $r->input('contact_number');
        $employee->email                 = $r->input('email');
        $employee->id_type               = $r->input('id_type');
        $employee->current_address_line_1 = $r->input('current_address.line_1');
        $employee->current_address_district = $r->input('current_address.district');
        $employee->current_address_province = $r->input('current_address.province');
        $employee->permanent_address_line_1 = $r->input('permanent_address.line_1');
        $employee->permanent_address_district = $r->input('permanent_address.district');
        $employee->permanent_address_province = $r->input('permanent_address.province');
        $employee->education_level = $r->input('education_level');
        $employee->education_field = $r->input('education_field');
        $employee->education_institution = $r->input('education_institution');
        $employee->post_id = $r->input('post_id');
        $post =  \App\Post::where('id', '=', $r->input('post_id'))->first();
        $post->has_employee = 1;
        $post->update();
        $employee->contract_start_date = $r->input('contract_start_date');
        $employee->contract_end_date = $r->input('contract_end_date');
        $employee->id_details = json_encode($idDetails);
        $employee->save();
        return $employee;
    }

    public function update(EmployeeRequest $r)
    {
        $employee                 = \App\Employee::where('id', $r->input('id'))->first();
        if (!$employee) {
            abort(404);
        }
        $idDetails = [
            'volume' => $r->input('id_details.volume', ''),
            'year' => $r->input('id_details.year', ''),
            'page' => $r->input('id_details.page', ''),
            'registeration' => $r->input('id_details.registration', ''),
            'sokok' => $r->input('id_details.sokok', ''),
            'nid_no' => $r->input('id_details.nid_no')
        ];
        $employee->name                  = $r->input('name');
        $employee->surname               = $r->input('surname');
        $employee->father_name           = $r->input('father_name');
        $employee->grand_father_name     = $r->input('grand_father_name', '-');
        $employee->dob                   = $r->input('dob');
        $employee->gender                = $r->input('gender');
        $employee->marital_status        = $r->input('marital_status');
        $employee->contact_number        = $r->input('contact_number');
        $employee->email                 = $r->input('email');
        $employee->id_type               = $r->input('id_type');
        if (in_array($r->user()->role, ['admin', 'manager'])) {
            $employee->current_address_line_1 = $r->input('current_address.line_1');
            $employee->current_address_district = $r->input('current_address.district');
            $employee->current_address_province = $r->input('current_address.province');
            $employee->center_id             = $r->input('center_id');
            $employee->permanent_address_line_1 = $r->input('permanent_address.line_1');
            $employee->permanent_address_district = $r->input('permanent_address.district');
            $employee->permanent_address_province = $r->input('permanent_address.province');
            $employee->education_level = $r->input('education_level');
            $employee->education_field = $r->input('education_field');
            $employee->education_institution = $r->input('education_institution');
            $post =  \App\Post::where('id', '=',  $employee->post_id )->first();
            $post->has_employee = 0;
            $post->update();
            $employee->post_id = $r->input('post_id');
            $employee->contract_start_date = $r->input('contract_start_date');
            $employee->contract_end_date = $r->input('contract_end_date');
        }

        $employee->id_details = json_encode($idDetails);
        $employee->save();
        return $employee;
    }

    public function show($employeeId)
    {
        $employee                 = \App\Employee::where('id', $employeeId)->first();
        if (!$employee) {
            abort(404);
        }
        return $employee;
    }

    public function destroy($employeeId)
    {
        $employee = Employee::where('id', $employeeId)->first();
        if (!$employee) {
            abort(404);
        }
        $employee->delete();
        return ['message' => 'Deleted!'];
    }

    public function updateStatus(Request $r)
    {
        $employee = \App\Employee::where('id', $r->input('employee_id'))->first();
        if (!$employee) {
            abort(404);
        }
        $employee->status = $r->input('status');
        $employee->update();
        if ($r->input('note')) {
            $employee->notes()->create([
                'user_id' => $r->user()->id,
                'note' => $r->input('note')
            ]);
        }

        return $employee;
    }

    public function getStatusList()
    {
        return Employee::getStatusList();
    }
}
