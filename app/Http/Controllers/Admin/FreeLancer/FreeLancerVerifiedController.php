<?php

namespace App\Http\Controllers\Admin\FreeLancer;

use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class FreeLancerVerifiedController extends Controller
{
    public function index()
    {
        return view('admin.FreeLancer.verified.index');

    }

    public function data(Request $request)
    {
        $freelancers = Freelancer::with(['user'])
            ->whereHas('identityVerification', function ($query) {
                $query->where('status', '1');
            });

        if ($request->filled('search')) {
            $search = $request->search;

            $freelancers = $freelancers->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        return DataTables::of($freelancers)
            ->addColumn('photo', fn($row) => '<img src="' . optional($row->user)->getImageUrl() . '" class="w-50px h-50px rounded-circle">')
            ->editColumn('mobile', function ($row) {
                if (!$row->user || !$row->user->country) {
                    return '-';
                }
                $flag = optional($row->user->country)->flag;
                $code = optional($row->user->country)->number_code ?? '';
                $mobile = optional($row->user)->mobile ?? '';

                return '<span class="d-flex align-items-center gap-2">
                <img src="' . $flag . '"  class="w-30px h-30px rounded-circle"  alt="Flag" >
                <span class="badge badge-light-primary">' . $code . ' ' . $mobile . '</span>
            </span>';
            })
            ->editColumn('date', function ($row) {
                return optional($row->user)->created_at
                    ? $row->user->created_at->format('d M, Y') . ' , ' . $row->user->created_at->diffForHumans()
                    : '-';
            })
            ->addColumn('name', fn($row) => optional($row->user)->name ?? '-')
            ->addColumn('email', fn($row) => optional($row->user)->email ?? '-')
            ->addColumn('actions', function ($row) {
                return '<div class="dropdown">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions <i class="ki-outline ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 edit-badge" data-id="' . $row->id . '">View</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-freelancer btn btn-active-light-danger" data-id="' . $row->id . '">Delete</a>
                            </div>


                             <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 status-freelancer btn btn-active-light-warning"   data-id="' . $row->id . '"  data-status="' . $row->user->status. '">Change Status</a>
                            </div>
                        </div>
                    </div>';
            })
            ->editColumn('status', function ($row) {
                return $row->user->status == 1
                    ? '<span class="badge badge-light-success">Active</span>'
                    : '<span class="badge badge-light-danger">Not Active</span>';
            })
            ->addIndexColumn()
            ->rawColumns(['actions', 'photo', 'mobile', 'status'])
            ->make(true);
    }


    public function status(Request $request, $id)
    {
        $freelancer = Freelancer::find($id);

        if (!$freelancer) {
            return response()->json(['message' => 'Freelancer not found.'], 404);
        }

        $user = $freelancer->user;
        $previousStatus = $user->status;
        $user->status = !$user->status;
        $user->save();

        // إرسال الإيميل حسب الحالة الجديدة
        if ($user->status) {
            // تم التفعيل
            Mail::to($user->email)->send(new \App\Mail\FreelancerActivated($user));
        } else {
            // تم التعطيل مع سبب
            $reason = $request->input('reason');
            Mail::to($user->email)->send(new \App\Mail\FreelancerDeactivated($user, $reason));
        }

        return response()->json(['message' => 'Freelancer status updated successfully.']);
    }


    public function destroy($id)
    {
        $freelancer = Freelancer::find($id);
        $freelancer->delete();
        return response()->json(['message' => 'Freelancer deleted successfully.']);

    }
}
