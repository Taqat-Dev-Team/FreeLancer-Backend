<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NotificationController extends Controller
{

    public function index()
    {
        return view('admin.Notifications.index');
    }


    public function data(Request $request)
    {
        $notifications = auth('admin')->user()->notifications()
            ->orderByRaw('read_at IS NOT NULL') // الغير مقروءة أولًا (NULL = false)
            ->orderByDesc('created_at');

        return DataTables::of($notifications)
            ->addIndexColumn()
            ->addColumn('title', function ($notif) {
                $data = is_string($notif->data) ? json_decode($notif->data, true) : $notif->data;
                return $data['title'] ?? '-';
            })
            ->addColumn('message', function ($notif) {
                $data = is_string($notif->data) ? json_decode($notif->data, true) : $notif->data;
                return $data['message'] ?? '-';
            })
            ->addColumn('created_at', function ($notif) {
                return $notif->created_at->diffForHumans() . ' - ' . $notif->created_at->format('Y.M.d H:i');
            })
            ->addColumn('read_at', function ($notif) {
                return $notif->read_at ? '<span class="badge badge-light-success">Read</span>' : '<span class="badge badge-light-warning">New</span>';
            })
            ->addColumn('action', function ($notif) {
                $data = is_string($notif->data) ? json_decode($notif->data, true) : $notif->data;
                $url = $data['url'] ?? '#';
                return '<a href="#" class="btn btn-sm btn-light-primary notification-link" data-id="' . $notif->id . '" data-url="' . $url . '">View</a>';
            })

            ->rawColumns(['read_at', 'action'])
            ->make(true);
    }


    public function deleteRead()
    {
        $admin = auth('admin')->user();

        $deleted = $admin->notifications()->whereNotNull('read_at')->delete();

        return response()->json([
            'message' => 'Read notifications deleted successfully.',
            'deleted' => $deleted
        ]);
    }


    public function read($id)
    {

        $admin = auth('admin')->user();
        $notification = $admin->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'not_found'], 404);
    }


}
