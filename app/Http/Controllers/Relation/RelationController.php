<?php

namespace App\Http\Controllers\Relation;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Phone;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class RelationController extends Controller
{
    ######################## one to one relationship methods #########################
    public function hasOneRelation()
    {
        $user = User::with(['phone' => function ($q) {
            $q->select('code', 'phon', 'user_id');
        }])->find(2);

        //return $user->phone->code;//967
        //return $user->name;//zainab
        //$phone = $user->phone;//print of table phone
        return response()->json($user);
    }

    public function hasOneRelationReverse()
    {
        //get all data of phone and id,name of model User
        $phone = Phone::with(['user' => function ($q) {
            $q->select('name', 'id');
        }])->find(1);

        $phone->user->makeHidden(['id']);

        //get all data phone and user
        // $phone = Phone::with('user')->find(1);

        //make some attributes visible
        $phone->makeVisible(['user_id']);
        //make some attributes hidden
        //$phone->makeHidden(['code']);
        // return $phone->user; //return user of this phone number

        return $phone;
    }
    public function getUserHasPhones()
    {
        //get-user-has-phones
        //return User::whereHas('phone')->get();

        //get-user-has-phones where condition code=967
        return User::whereHas('phone', function ($q) {
            $q->where('code', 967);
        })->get();
    }
    public function getUserNotHasPhones()
    {
        return User::whereDoesntHave('phone')->get();
    }

    ######################## one to many relationship methods#########################

    public function getHospitalDoctors()
    {
        //three way to get row of hospital table
        //Retrieve the hospital with ID 1 and get its associated doctors.
        // $hospital = Hospital::find(1);
        // $hospital = Hospital::where('id', 1)->get();
        // $hospital = Hospital::first();

        // return $hospital->doctors; //This retrieves the doctors associated with the specified hospital.

        // $hospital = Hospital::with(['doctors' => function ($q) {
        //     $q->select('name', 'title', 'hospital_id');
        // }])->get();

        $hospital = Hospital::with('doctors')->find(1);

        // $doctors = $hospital->doctors;
        // // foreach ($doctors as $doctor) {
        // //     $doctor->makeHidden('hospital_id');
        // //     echo $doctor->name . '<br>';
        // }

        // Retrieve all hospitals along with their associated doctors in a single query.
        //$hospital = Hospital::with('doctors')->get();

        //return response()->json($hospital);

        $doctor = Doctor::find(3);
        return $doctor->hospital->name;
    }
    #############################################################
    public function hospitals()
    {
        $hospitals = Hospital::select('id', 'name', 'address')->get();
        return view('doctors.hospitals', compact('hospitals'));
    }
    ####################################################
    public function doctors($id_hospital)
    {
        $hospital = Hospital::find($id_hospital);
        if (!$hospital) {
            // يمكنك إعادة توجيه المستخدم إلى صفحة أخرى أو عرض رسالة خطأ
            return redirect()->back()->with('error', 'لم يتم العثور على المستشفى المطلوب');
        }
        $doctors = $hospital->doctors;
        return view('doctors.doctors', compact('doctors'));
    }
    #####################################################
    public function deleteHospitals($id)
    {
        $hospital = Hospital::find($id);
        if (!$hospital) {
            // يمكنك إعادة توجيه المستخدم إلى صفحة أخرى أو عرض رسالة خطأ
            // return redirect()->back()->with('error', 'لم يتم العثور على المستشفى المطلوب');
            return abort('404');
        }
        //delete doctors in this hospitals
        $hospital->doctors()->delete();

        //delete parent hospital
        $hospital->delete();
        return redirect()->back()->with(['success' => 'تم حذف المستشفى بنجاح']);
    }
    ######################################################
    public function deletsDoctor($id_doctor)
    {
        $doctor = Doctor::find($id_doctor);
        if (!$doctor) {
            return redirect()->back()->with('error', 'لم يتم العثور على الطبيب المطلوب');
        }
        $doctor->delete();

        // إعادة التوجيه إلى صفحة الأطباء المرتبطين بالمستشفى
        return redirect()->route('hospitals')->with('success', 'تم حذف الطبيب بنجاح');

    }
    #####################################################
    //get all hospital which must has doctors
    public function getHospitalsHasDoctor()
    {
        $hospital = Hospital::whereHas('doctors')->get();
        //$hospital = Hospital::with('doctors')->get();
        return $hospital;
    }

    public function getHospitalsHasDoctorMale()
    {
        // $hospital = Hospital::with('doctors')->whereHas('doctors', function ($q) {
        //     $q->where('gender', 1);
        // })->get();
        // return $hospital;

        $hospital = Hospital::with(['doctors' => function ($q) {
            $q->where('gender', 1);
        }])->whereHas('doctors', function ($q) {
            $q->where('gender', 1);
        })->get();
        return $hospital;
    }

    public function getHospitalsNotHasDoctor()
    {
        $hospital = Hospital::whereDoesntHave('doctors')->get();
        //$hospital = Hospital::with('doctors')->get();
        return $hospital;
    }

    ######################## many to many relationship methods #########################
    public function getDoctorServices()
    {
        $doctor = Doctor::with('services')->find(21);
        if (!$doctor) {
            return response()->json(['error' => 'لم يتم العثور على الطبيب المطلوب'], 404);
        }
        return $services = $doctor->services;

    }
    public function getServiceDoctor()
    {
        // $service = Service::find(1);
        // return $doctor = $service->doctors; //display the doctore
        //return $doctors = Service::find(1)->doctors;//another another

        // return $doctors = Service::with(['doctors' => function ($q) {
        //     $q->select('doctors.id', 'name', 'title');
        // }])->find(2); //display service with doctor

        //$Service_doctors = Service::with('doctors')->find(2)->doctors->makeHidden(['hospital_id', 'gender']);//display collect donly doctors

        $Service_doctors = Service::with('doctors')->find(2); //display service with doctor

        if ($Service_doctors) {
            $Service_doctors->doctors->each(function ($q) {
                $q->makeHidden(['hospital_id', 'gender']);
            });
        }
        return $Service_doctors;

    }

    public function getDoctorServic($doctorId)
    {
        $doctor = Doctor::find($doctorId);
        $service = $doctor->services;

        $doctors = Doctor::select('id', 'name')->get();
        $allservices = Service::select('id', 'name')->get();

        return view('doctors.services', compact('service', 'doctors', 'allservices'));
    }

    public function saveServicesToDoctor(Request $request)
    {
        $doctor = Doctor::find($request->doctor_id);
        if (!$doctor) {
            return redirect()->back()->with('error', 'لم يتم العثور على الطبيب المطلوب');
        }
        // $doctor->services()->attach($request->service_id); ///many to many insert to database with again
        //$doctor->services()->sync($request->service_id);//insert into database and delete of old database==update
        $doctor->services()->syncWithoutDetaching($request->service_id); //insert into database and add only not again
        return 'success';

    }

}
