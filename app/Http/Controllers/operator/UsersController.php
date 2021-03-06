<?php

namespace App\Http\Controllers\operator;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\DB;
use Alert;
use Softon\SweetAlert\Facades\SWAL;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexManager()
    {
        $data['users'] = DB::table('users')->where('type', 'Manager')->get();

        return view('operator.testshowManager', $data);
    }

    public function indexStudent()
    {
        $data['users'] = DB::table('users')->where('type', 'Student')->get();

        return view('operator.testshowStudent', $data);
    }

    public function indexProf()
    {
        $data['users'] = DB::table('users')->where('type', 'Prof')->get();

        return view('operator.testshowProf', $data);
    }

    public function indexEmployee()
    {
        $data['users'] = DB::table('users')->where('type', 'Employee')->get();

        return view('operator.testshowEmployee', $data);
    }

    public function indexOperator()
    {
        $data['users'] = DB::table('users')->where('type', 'Operator')->get();

        return view('operator.testshowOperator', $data);
    }

    public function create()
    {
        return view('operator.testCreateUser');
    }


    public function store(UserRequest $request)
    {
        //User::create($request->all());
        $user = new user();
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $client_name = $request->national_id . '.' . $photo->getClientOriginalExtension();
            $dir_upload = public_path() . '/upload_files/users/';
            $photo->move($dir_upload, $client_name);
            $user->photo = $client_name;
        }
        $user->type = $request->type;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->post_id = $request->post_id;
        $user->password = $request->password;
        $user->email = $request->email;
        $user->sex = $request->sex;
        $user->edu = $request->edu;
        $user->phone = $request->password;
        $user->date_birth = $request->date_birth;
        $user->address = $request->address;
        $user->national_id = $request->national_id;
        $user->save();
        swal()->success('','   کاربر با موفقیت ثبت شد');
        return redirect(route('users.create'))->with('successMsg', 'user successfully added');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $user = User::find($id);
        return view('operator.testeditUser', compact('user'));

    }


    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        if($request->hasfile('photo')){
            $dir_upload = public_path() . '/upload_files/users/';
            if(!empty($user->photo)){
                \File::delete($dir_upload .$user->photo);
            }
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $client_name = $request->national_id . '.' . $photo->getClientOriginalExtension();
                $dir_upload = public_path() . '/upload_files/users/';
                $photo->move($dir_upload, $client_name);
                $user->photo = $client_name;
            }

        }
        $user->type = $request->type;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->post_id = $request->post_id;
        $user->password = $request->password;
        $user->email = $request->email;
        $user->sex = $request->sex;
        $user->edu = $request->edu;
        $user->phone = $request->password;
        $user->date_birth = $request->date_birth;
        $user->address = $request->address;
        $user->national_id = $request->national_id;
        $user->save();
        if ($user->type == 'Student') {
            swal()->success('','  تغییر مورد نظر باموفقیت برای دانشجوی  مورد نظر اعمال شد');
            return redirect(route('users.indexstudent'));
        } else if ($user->type == 'Prof') {
            swal()->success('','  تغییر مورد نظر باموفقیت برای استاد  مورد نظر اعمال شد');
            return redirect(route('users.indexprof'));
        } else if ($user->type == 'Manager') {
            swal()->success('','  تغییر مورد نظر باموفقیت برای مدیرگروه  مورد نظر اعمال شد');
            return redirect(route('users.indexmanager'));
        } else if ($user->type == 'Operator') {
            swal()->success('','  تغییر مورد نظر باموفقیت برای مسول سیستم  مورد نظر اعمال شد');
            return redirect(route('users.indexoperator'));
        } else {
            swal()->success('','  تغییر مورد نظر باموفقیت برای کارمند  مورد نظر اعمال شد');
            return redirect(route('users.indexemployee'));
        }


    }


    public function deleteManager($id)
    {

        $user = User::where('id', $id)->first();
        if ($user) {
            $user->delete();
            return redirect()->route('users.indexmanager');
        }
        return redirect()->route('users.indexmanager');
    }

    public function deleteStudent($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->delete();
            return redirect()->route('users.indexstudent');
        }
        return redirect()->route('users.indexstudent');

    }

    public function deleteProf($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->delete();
            return redirect()->route('users.indexprof');
        }
        return redirect()->route('users.indexprof');
    }

    public function deleteEmployee($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->delete();
            return redirect()->route('users.indexemployee');
        }
        return redirect()->route('users.indexemployee');
    }

    public function deleteOperator($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->delete();
            return redirect()->route('users.indexoperator');
        }
        return redirect()->route('users.indexoperator');

    }


}
