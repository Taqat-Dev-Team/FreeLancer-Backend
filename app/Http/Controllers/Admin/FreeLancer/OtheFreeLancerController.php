<?php

namespace App\Http\Controllers\Admin\FreeLancer;

use App\Http\Controllers\Controller;
use App\Mail\AdminMessageToFreelancer;
use App\Models\Freelancer;
use App\Models\IdentityVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class OtheFreeLancerController extends Controller
{
    public function index()
    {
        return view('admin.FreeLancer.other.index');

    }

    public function data(Request $request)
    {
        $freelancers = Freelancer::with(['user.country'])
            ->whereDoesntHave('identityVerification');


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
            ->addColumn('availability', function ($row) {
                if ($row->availability()) {
                    return '<span class="badge badge-light-primary">Available To Hire</span>';
                }

                $modalId = 'availabilityModal_' . $row->id;

                return '<span class="badge badge-light-warning cursor-pointer" data-bs-toggle="modal" data-bs-target="#' . $modalId . '">Not Available To Hire</span>'
                    . view('admin.FreeLancer.verified.partials.availability_modal', ['row' => $row, 'modalId' => $modalId])->render();
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
                    <a href="' . route('admin.freelancers.show', $row->id) . '" class="menu-link px-3 edit-badge" data-id="' . $row->id . '">View</a>
                </div>

                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3 delete-freelancer btn btn-active-light-danger" data-id="' . $row->id . '">Delete</a>
                </div>';

                // ✅ إظهار زر تفعيل من قبل الأدمن فقط إذا غير مفعل
                if (!$row->admin_available_hire) {
                    $actions .= '
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3 toggle-admin-availability-active btn btn-active-light-primary"
                   data-id="' . $row->id . '" data-status="' . $row->admin_available_hire . '">
                   Activate by Admin
                </a>
            </div>';
                } else {
                    $actions .= '

           <div class="menu-item px-3">
                <a href="#" class="menu-link px-3 toggle-admin-availability-deactivate btn btn-active-light-primary"
                   data-id="' . $row->id . '" data-status="' . $row->admin_available_hire . '">
                  Deactivate by Admin
                </a>
            </div>';
                }

                // ✅ زر تغيير حالة المستخدم
                $actions .= '
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3 status-freelancer btn btn-active-light-warning"
               data-id="' . $row->id . '" data-status="' . $row->user->status . '">
               Change Status
            </a>
        </div>';

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
            ->editColumn('status', function ($row) {
                return $row->user->status == 1
                    ? '<span class="badge badge-light-success" >Active</span>'
                    : '<span class="badge badge-light-danger" >Not Active</span>';
            })
            ->addIndexColumn()
            ->rawColumns(['actions', 'photo', 'mobile', 'status', 'availability'])
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


    public function ActiveByAdmin($id)
    {
        $freelancer = Freelancer::find($id);
        if (!$freelancer) {
            return response()->json(['message' => 'Freelancer not found.'], 404);
        }

        $freelancer->admin_available_hire = 1;
        Mail::to($freelancer->user->email)->send(new AdminMessageToFreelancer(trans('messages.freelancer_admin_active', [], $freelancer->user->lang ?? 'ar'), $freelancer->user));

        $freelancer->save();

        return response()->json(['message' => 'Freelancer admin availability updated successfully.']);

    }

    public function deactivateByAdmin($id)
    {
        $freelancer = Freelancer::find($id);
        if (!$freelancer) {
            return response()->json(['message' => 'Freelancer not found.'], 404);
        }

        $freelancer->admin_available_hire = 0;
        Mail::to($freelancer->user->email)->send(new AdminMessageToFreelancer(trans('messages.freelancer_admin_deactivate', [], $freelancer->user->lang ?? 'ar'), $freelancer->user));

        $freelancer->save();

        return response()->json(['message' => 'Freelancer admin availability updated successfully.']);

    }

    public function destroy($id)
    {
        $freelancer = Freelancer::find($id);
        $freelancer->delete();
        return response()->json(['message' => 'Freelancer deleted successfully.']);

    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:freelancers,id',
            'message' => 'required|string|max:2000',
        ]);

        $freelancer = Freelancer::with('user')->find($request->id);

        if (!$freelancer || !$freelancer->user || !$freelancer->user->email) {
            return response()->json(['message' => 'Freelancer email not found.'], 404);
        }

        // إرسال البريد
        Mail::to($freelancer->user->email)->send(new AdminMessageToFreelancer($request->message, $freelancer->user));

        return response()->json(['message' => 'Message sent successfully!']);
    }


    public function show($id)
    {
        $freelancer = Freelancer::find($id);

        if (!$freelancer) {
            return response()->json(['message' => 'Freelancer not found.'], 404);
        }

        $idHistory=$freelancer->identityVerification()->get();
        return view('admin.FreeLancer.index', compact('freelancer','idHistory'));

    }
}
