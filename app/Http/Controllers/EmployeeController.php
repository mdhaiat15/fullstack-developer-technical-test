<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $employees = Employee::with(['position'])->get();
            $employees->each(function ($employee) {
                $employee->agama_label = $employee->agama_label;
                $employee->status_label = $employee->status_label;
            });
            return datatables($employees)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '
                    <div class="d-flex justify-content-between">
                        <a href="javascript:void(0)" id="btn-edit-employee" class="btn btn-primary btn-sm mr-2 btn-edit">EDIT</a>
                        <a href="javascript:void(0)" id="btn-delete-employee" data-rowid="' . $row->id . '" class="btn btn-danger btn-sm btn-delete">DELETE</a>
                    </div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $listDataAgama = Employee::listAgama();
        $listDataStatus = Employee::listStatus();
        $listDataJabatan = Position::pluck('name', 'id');

        $variableToView = ['listDataAgama', 'listDataStatus', 'listDataJabatan'];

        return view('employee')->with(compact($variableToView));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'nip'   => 'required|unique:employees,nip',
            'position_id'   => 'required',
            'alamat'   => 'required',
            'tgl_lahir'   => 'required',
            'thn_lahir'   => 'required',
            'tlp'   => 'required|numeric',
            'departemen'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->nip = $request->nip;
        $employee->position_id = $request->position_id;
        $employee->alamat = $request->alamat;
        $employee->tgl_lahir = $request->tgl_lahir;
        $employee->thn_lahir = $request->thn_lahir;
        $employee->tlp = $request->tlp;
        $employee->departemen = $request->departemen;
        $employee->agama = $request->agama;
        $employee->status = $request->status;
        $employee->save();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $employee
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Karyawan',
            'data'    => $employee
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'nip'   => 'required|unique:employees,nip,'.$employee->id,
            'position_id'   => 'required',
            'alamat'   => 'required',
            'tgl_lahir'   => 'required',
            'thn_lahir'   => 'required',
            'tlp'   => 'required|numeric',
            'departemen'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $employee->name = $request->name;
        $employee->nip = $request->nip;
        $employee->position_id = $request->position_id;
        $employee->alamat = $request->alamat;
        $employee->tgl_lahir = $request->tgl_lahir;
        $employee->thn_lahir = $request->thn_lahir;
        $employee->tlp = $request->tlp;
        $employee->departemen = $request->departemen;
        $employee->agama = $request->agama;
        $employee->status = $request->status;
        $employee->save();

        // Return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diperbarui!',
            'data'    => $employee
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!',
        ]);
    }
}
