<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceFileFormatRequest;
use App\Http\Requests\Admin\UpdateServiceFileFormatRequest;
use App\Models\Category;
use App\Models\ServiceFileFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ServiceFileFormatController extends Controller
{
    public function index()

    {
        $categories = Category::all();
        return view('admin.management.ServiceFileFormat.index', ['categories' => $categories]);
    }


    public function getData(Request $request)
    {
        $skills = ServiceFileFormat::with('category');

        if ($request->has('category_id') && is_array($request->category_id) && count(array_filter($request->category_id))) {
            $skills = $skills->whereIn('category_id', $request->category_id);
        }

        if ($request->has('search')) {
            $search = strtolower($request->search);
            $skills = $skills->where(function ($query) use ($search) {
                $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.en'))) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar'))) LIKE ?", ["%{$search}%"])
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.en'))) LIKE ?", ["%{$search}%"])
                            ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar'))) LIKE ?", ["%{$search}%"]);
                    });

            });
        }

        return DataTables::of($skills)
            ->editColumn('category', fn($row) => '<span class="badge badge-light-primary">' . $row->category->getTranslation('name', 'en') . ' -- ' . $row->category->getTranslation('name', 'ar') . '</span>')
            ->addColumn('actions', function ($row) {
                return '<div class="dropdown">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions <i class="ki-outline ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 edit-format" data-id="' . $row->id . '">Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-format btn btn-active-light-danger" data-id="' . $row->id . '">Delete</a>
                            </div>
                        </div>
                    </div>';
            })
            ->addIndexColumn()
            ->rawColumns(['actions', 'category'])
            ->make(true);
    }


    public function destroy($id)
    {
        $skill = ServiceFileFormat::withCount('services')->findOrFail($id);

        if ($skill->services_count > 0) {
            return response()->json(['message' => 'Cannot delete Format associated with Services.'], 400);
        }

        $skill->delete();
        return response()->json(['success' => true, 'message' => 'Skill deleted successfully.']);

    }

    public function store(StoreServiceFileFormatRequest $request)
    {
        try {
            $skill = new ServiceFileFormat();
            $skill->setTranslation('name', 'en', $request->name_en);
            $skill->setTranslation('name', 'ar', $request->name_ar);
            $skill->category_id = $request->category_id;
            $skill->save();


            return response()->json(['message' => 'Format added successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unexpected error.'], 500);
        }
    }


    public function show($id)
    {
        $skill = ServiceFileFormat::findOrFail($id);
        return response()->json([
            'id' => $skill->id,
            'category_id' => $skill->category_id,
            'name_en' => $skill->getTranslation('name', 'en'),
            'name_ar' => $skill->getTranslation('name', 'ar'),
        ]);
    }

    public function update(UpdateServiceFileFormatRequest $request, $id)
    {

        try {

            $skill = ServiceFileFormat::findOrFail($id);
            $skill->setTranslation('name', 'en', $request->name_en);
            $skill->setTranslation('name', 'ar', $request->name_ar);
            $skill->category_id = $request->category_id;
            $skill->save();


            return response()->json(['message' => 'Format updated successfully.']);


        } catch (\Exception $e) {
            return response()->json(['message' => 'Unexpected error.'], 500);
        }
    }

}
