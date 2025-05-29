<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;


class CategoryController extends Controller
{

    public function index()
    {
        return view('admin.management.categories.index');
    }


    public function getData(Request $request)
    {
        $categories = Category::withCount('subCategories');

        return DataTables::of($categories)
            ->addColumn('icon', function ($row) {

                return '    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
																<a href="#">
																	<div class="symbol-label">
																		<img src="' . url($row->getImage()) . ' " alt="Emma Smith" class="w-100">
																	</div>
																</a>
															</div>';


            })

            ->editColumn('sub_categories_count', function ($row) {
                return '<div class="badge badge-light-info fw-bold rounded text-center">'.$row->sub_categories_count.'</div>';
            })
            ->addColumn('actions', function ($row) {
                return    '<div class="dropdown">
            <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    Actions <i class="ki-outline ki-down fs-5 ms-1"></i>
            </a>
            <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3 edit-category" data-id="'.$row->id.'">Edit</a>
                </div>
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3 delete-category" data-id="'.$row->id.'">Delete</a>
                </div>
            </div>
        </div>';
            })
            ->rawColumns(['icon', 'actions','sub_categories_count'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function edit($id)
    {
        return view('admin.categories.edit', compact('id'));
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return response()->json([
            'id' => $category->id,
            'name_en' => $category->getTranslation('name', 'en'),
            'name_ar' => $category->getTranslation('name', 'ar'),
            'icon' => $category->getImage(), // optional: for preview if needed
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->icon && Storage::exists($category->icon)) {
            Storage::delete($category->icon);
        }

        // Delete category from database
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $category = Category::findOrFail($id);

        if ($request->hasFile('icon')) {
            if ($category->icon && Storage::disk('public')->exists($category->icon)) {
                Storage::disk('public')->delete($category->icon);
            }

            // Store new icon
            $path = $request->file('icon')->store('categories', 'public');
            $category->icon = $path;
        }

        $category->setTranslation('name', 'en', $request->name_en);
        $category->setTranslation('name', 'ar', $request->name_ar);
        $category->save();

        return response()->json(['message' => 'Category updated successfully.']);
    }


}
