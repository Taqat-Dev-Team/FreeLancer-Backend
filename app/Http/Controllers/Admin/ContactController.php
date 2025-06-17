<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBadgeRequest;
use App\Http\Requests\Admin\UpdateBadgeRequest;
use App\Models\Badge;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ContactController extends Controller
{

    public function index()
    {
        return view('admin.contacts.index');
    }


    public function getData(Request $request)
    {
        $badges = Contact::query();
        if ($request->has('search')) {
            $search = strtolower($request->search);
            $badges = $badges->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }


        return DataTables::of($badges)
            ->editColumn('message', fn($row) => Str::limit($row->message, 80))
            ->editColumn('title', fn($row) => Str::limit($row->title, 20))
            ->editColumn('status', fn($row) => '<span class="text-center badge ' . ($row->status == 0 ? 'badge-light-danger' : ($row->status == 1 ? 'badge-light-success' : 'badge-light-info')) . '">' . ($row->status == 0 ? 'New' : ($row->status == 1 ? 'Read' : 'Replied')) . '</span>')->addColumn('actions', function ($row) {
                return '<div class="dropdown">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions <i class="ki-outline ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="'.route('admin.contacts.show',$row->id).'" class="menu-link px-3" data-id="' . $row->id . '">View</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-contact btn btn-active-light-danger" data-id="' . $row->id . '">Delete</a>
                            </div>
                        </div>
                    </div>';
            })
            ->addIndexColumn()
            ->rawColumns(['actions', 'status', 'message'])
            ->make(true);
    }


    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['status'=>1]);
        return view('admin.contacts.show',['contact'=>$contact]);
    }


    public function update(UpdateBadgeRequest $request, $id)
    {

        try {
            $badge = Badge::findOrFail($id);

            $badge->setTranslation('name', 'en', $request->name_en);
            $badge->setTranslation('name', 'ar', $request->name_ar);
            $badge->setTranslation('description', 'en', $request->description_en);
            $badge->setTranslation('description', 'ar', $request->description_ar);
            $badge->save();

            if ($request->hasFile('icon')) {
                $badge->clearMediaCollection('icon');
                $badge->addMediaFromRequest('icon')
                    ->usingFileName(Str::random(20) . '.' . $request->file('icon')->getClientOriginalExtension())
                    ->toMediaCollection('icon', 'badges');
            }

            return response()->json(['message' => 'Badge updated successfully.']);
        } catch (\Exception $e) {
            Log::error("Badge update error: " . $e->getMessage());
            return response()->json(['message' => 'Unexpected error.'], 500);
        }

    }


    public function destroy($id){
        $badge = Contact::findOrFail($id);
        $badge->delete();
        return response()->json(['message' => 'Contact deleted successfully.']);
    }


}
