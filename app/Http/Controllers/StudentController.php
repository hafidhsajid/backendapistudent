<?php

namespace App\Http\Controllers;

use App\Models\students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = new students();
        if (isset($_GET['search'])) {
            return response()->json([
                'status' => 'success',
                'data' => $data->where('name', 'like', '%' . $_GET['search'] . '%')->get()
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $data->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('creat');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = new students();

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = $request->name.date('YmdHi') . $file->getClientOriginalName();
                // $file->move(public_path('image'), $filename);
            //     $data['avatar'] = $filename;
            $data->avatar = $filename;
        }
        $data->name = $request->name;
        $data->gender = $request->gender;
        $data->dob = $request->dob;
        $rules =
            [
                'name' => 'required',
                'gender' => 'required',
                'dob' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);

        try {
            if ($validator->fails()) {
                throw new ("Error Processing Request");
            }
            if ($data->save()) {
                // $file = $request->file('image');
                if ($request->file('image')) {
                    // $filename = date('YmdHi') . $file->getClientOriginalName();
                    // $file = $request->file('image');
                    // $file->move(base_path('\public\images'), $file->getClientOriginalName());
                    if(!$file->move(public_path('image'), $filename)){
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Error in uploading image'
                        ]);
                    };
                }
                // $data['avatar'] = $filename;
            };
            return response()->json([
                'status' => 'success',
                'message' => 'Student created successfully',
                'data' => $data,
                'req' => $request
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Student created failed',
                'data' => $th,
                'req' => $request->all()
            ], 500);
        }
        // dd($request);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = students::find($id);

        return response()->json($data);

        // dd($data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = students::find($id);
        // dd($data);

        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = $request->name. date('YmdHi') . $file->getClientOriginalName();
            //     $file->move(public_path('public/Image'), $filename);
            //     $data['avatar'] = $filename;
            $data->avatar = $filename;
        }
        $data->name = $request->name;
        $data->gender = $request->gender;
        $data->dob = $request->dob;
        $rules =
            [
                'name' => 'required',
                'gender' => 'required',
                'dob' => 'required',
            ];
        $validator = Validator::make($request->all(), $rules);


        try {
            if ($validator->fails()) {
                throw new ("Error Processing Request");
            }
            if ($data->save()) {
                // $file = $request->file('image');
                // $filename = date('YmdHi') . $file->getClientOriginalName();
                // $file->move(public_path('public/Image'), $filename);
                // $data['avatar'] = $filename;
                if(!$file->move(public_path('image'), $filename)){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Error in uploading image'
                    ]);
                };
            };
            return response()->json([
                'status' => 'success',
                'message' => 'Student updated successfully',
                'data' => $data,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Student updated failed',
                'data' => $th
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = students::find($id);

        try {

            if ($data->delete()) {
                if(!unlink(public_path('image/' . $data->avatar))){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Error in server'
                    ]);
                };
                // unlink(public_path('image/' . $data->avatar));
                return response()->json([
                    'status' => 'success',
                    'message' => 'Student deleted successfully',
                    'data' => $data,
                ], 200);
            }
        } catch (\Throwable $th) {

            return response()->json([
                'status' => 'fail',
                'message' => 'Student deleted failed',
                'data' => $data,
            ], 500);
        }
    }
}
