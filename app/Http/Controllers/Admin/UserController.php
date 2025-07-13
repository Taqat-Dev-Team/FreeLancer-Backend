<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Mail\AdminMessageToUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public function index()
    {
        return view('admin.Users.index');
    }


    public function data(Request $request)
    {
        $users = User::whereDoesntHave('freelancer')
            ->whereDoesntHave('client');

        if ($request->has('search')) {
            $search = strtolower($request->search);

            $users = $users->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }


        return DataTables::of($users)
            ->addColumn('photo', fn($row) => '<img src="' . $row->getImageUrl() . '" class="w-50px h-50px rounded-circle">')
            ->editColumn('date', function ($row) {
                return $row->created_at
                    ? $row->created_at->format('d M, Y') . ' , ' . $row->created_at->diffForHumans()
                    : '-';
            })
            ->editColumn('status', function ($row) {
                return $row->status == 1
                    ? '<span class="badge badge-light-success" >Active</span>'
                    : '<span class="badge badge-light-danger" >Not Active</span>';
            })
            ->addColumn('actions', function ($row) {
                $actions = '
        <div class="dropdown">
            <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
               data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                Actions <i class="ki-outline ki-down fs-5 ms-1"></i>
            </a>
            <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3"
                 data-kt-menu="true">



                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3 delete-freelancer btn btn-active-light-danger" data-id="' . $row->id . '">Delete</a>
                </div>';


//                // ✅ زر تغيير حالة المستخدم
//                $actions .= '
//        <div class="menu-item px-3">
//            <a href="#" class="menu-link px-3 status-freelancer btn btn-active-light-warning"
//               data-id="' . $row->id . '" data-status="' . $row->status . '">
//               Change Status
//            </a>
//        </div>';
//
                // ✅ زر إرسال رسالة
                $actions .= '
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3 message-freelancer btn btn-active-light-info"
               data-id="' . $row->id . '">
               Send Message
            </a>
        </div>
    </div>
</div>';

                return $actions;
            })
            ->addIndexColumn()
            ->rawColumns(['actions', 'photo', 'status', 'date'])
            ->make(true);
    }


    public function status(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }


        $user->status = !$user->status;
        $user->save();

        if ($user->status) {
            // تم التفعيل
            Mail::to($user->email)->send(new \App\Mail\FreelancerActivated($user));
        } else {
            // تم التعطيل مع سبب
            $reason = $request->input('reason');
            Mail::to($user->email)->send(new \App\Mail\FreelancerDeactivated($user, $reason));
        }

        return response()->json(['message' => 'User status updated successfully.']);
    }


    public function destroy($id)
    {
        $badge = User::findOrFail($id);
        $badge->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'message' => 'required|string|max:2000',
        ]);

        $user = User::find($request->id);

        if (!$user || !$user->email) {
            return response()->json(['message' => 'User email not found.'], 404);
        }

        // إرسال البريد
        Mail::to($user->email)->send(new AdminMessageToUser($request->message, $user));

        return response()->json(['message' => 'Message sent successfully!']);
    }


}
