<?php

namespace App\Http\Controllers\Admin\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\AdminMessageStatusService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ClientController extends Controller
{

    protected $adminService;

    public function __construct(AdminMessageStatusService $adminService)
    {
        $this->adminService = $adminService;
    }


    public function index()
    {
        return view('admin.Clients.index');
    }


    public function data(Request $request)
    {
        $clients = Client::with(['user', 'user.country']);

        if ($request->filled('search')) {
            $search = $request->search;

            $clients = $clients->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }


        return DataTables::of($clients)
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
            ->editColumn('status', function ($row) {
                return $row->user->status == 1
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
                    <a href="' . route('admin.clients.show', $row->id) . '" class="menu-link px-3 edit-badge" data-id="' . $row->id . '">View</a>
                </div>


                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3 delete-freelancer btn btn-active-light-danger" data-id="' . $row->id . '">Delete</a>
                </div>';


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
            ->addIndexColumn()
            ->rawColumns(['actions', 'photo', 'status', 'date', 'mobile'])
            ->make(true);
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);
        return view('admin.Clients.show', ['client' => $client]);
    }


    public function destroy($id)
    {

        $client = Client::find($id);
        $client->user->delete();
        $client->delete();
        return response()->json(['message' => 'Client deleted successfully.']);

    }


    public function status(Request $request, $id)
    {
        $client = Client::findOrFail($id);
        $user = $client->user;
        return $this->adminService->toggleStatus($user, $request->reason);
    }


    public function sendMessage(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'message' => 'required|string|max:2000',
        ]);

        $client = Client::with('user')->findOrFail($request->id);
        return $this->adminService->sendMessage($client->user, $request->message);
    }
}
