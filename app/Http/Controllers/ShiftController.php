<?php

namespace App\Http\Controllers;

use Auth;
use App\ShiftHour;
use App\workingStaff;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{
    public function workingHours()
    {
        return view('home.workingStaff');
    }

    public function getShiftForm()
    {
        return view('home.newShiftHours');
    }

    public function workingTeam()
    {
        return view('home.workingTeam');
    }
    public function addShift(Request $request)
    {
        $calcWorkingHours =
            strtotime($request->timeOut) - strtotime($request->timeIn);
        $convertIntoHours = $calcWorkingHours / 3600;

        $newShift = new ShiftHour();
        $newShift->name = $request->name;
        $newShift->timeIn = $request->timeIn;
        $newShift->timeOut = $request->timeOut;
        $newShift->workingHours = $convertIntoHours;
        $newShift->created_by = \Auth::user()->id;
        $newShift->save();

        return $this->successNotification();
    }
    public function allocateShifts()
    {
        return view('home.allocateShifts');
    }

    public function getShifts()
    {
        $shifts = \DB::table('shift_hours')->get();

        return Datatables::of($shifts)
            ->addColumn('action', function ($shifts) {
                if (Auth::user()->roleId == 1) {
                    return '<a href="#edit-' .
                        $shifts->id .
                        '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                }
                if (Auth::user()->roleId == 2) {
                    return '<a  class="btn btn-xs btn-primary"   data-toggle="modal"  data-target=".modalError"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                }
            })
            ->make(true);
    }
    public function getShiftTeam()
    {
        $teamOnshifts = WorkingStaff::with(['staff', 'hour'])->get();

        return Datatables::of($teamOnshifts)
            ->addColumn('action', function ($teamOnshifts) {
                if (Auth::user()->roleId == 1) {
                    return '<a href="#edit-' .
                        $teamOnshifts->id .
                        '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                }

                if (Auth::user()->roleId == 2) {
                    return '<a  class="btn btn-xs btn-primary"   data-toggle="modal"  data-target=".modalError"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                }
            })
            ->make(true);
    }

    public function getShiftDetails(Request $request)
    {
        // $searchString = \Input::get('q');
        $searchString = $request->q;
        $shifts = \DB::table('shift_hours')
            ->whereRaw("CONCAT(`shift_hours`.`name`) LIKE '%{$searchString}%'")
            ->select([
                'shift_hours.id as id',
                'shift_hours.name as name',
                'shift_hours.timeOut as timeOut',
                'shift_hours.timeIN as timeIN',
            ])
            ->get();
        $data = [];
        foreach ($shifts as $shift) {
            $data[] = [
                'name' => "{$shift->name}",
                'id' => "{$shift->id}",
            ];
        }

        return $data;
    }

    public function allocateNewShift(Request $request)
    {
        $this->validateInput($request->all())->validate();
        try {
            $workingStaff = new workingStaff();
            $workingStaff->shiftHoursId = $request->shiftHoursId;
            $workingStaff->staffId = $request->staffId;
            $workingStaff->save();
            Log::critical(['new record', $workingStaff]);
            return $this->successNotification();
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Error message' . $e->getMessage(),
                'alert-type' => 'error',
            ];
            Log::critical(['message', $e->getMessage()]);

            return back()->with($notification);
        }
    }

    public function successNotification()
    {
        $notification = [
            'message' => 'A record was saved',
            'alert-type' => 'success',
        ];

        return back()->with($notification);
    }
    protected function validateInput(array $data)
    {
        return Validator::make($data, [
            'staffId' => 'required|unique:working_staffs',
            'shiftHoursId' => 'required ',
        ]);
    }
}
