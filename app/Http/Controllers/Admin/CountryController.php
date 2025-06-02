<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class CountryController extends Controller
{
    public function index()
    {
        return view('admin.management.countries.index');
    }

    public function getData(Request $request)
    {
        $categories = Country::orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $search = strtolower($request->search);
            $categories = $categories->where(function ($query) use ($search) {
                $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.en'))) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar'))) LIKE ?", ["%{$search}%"])
                    ->orWhere('code', 'LIKE', "%{$search}%")
                    ->orWhere('number_code', 'LIKE', "%{$search}%");

            });
        }

        return DataTables::of($categories)
            ->addColumn('flag', function ($row) {
                $countryCode = strtolower($row->code); // مثال: "SA" => "sa"
                $flagUrl = "https://flagcdn.com/w40/{$countryCode}.png";
                return '<img src="' . $flagUrl . '"  class="w-30px h-30px rounded-circle"  alt="Flag">';
            })
            ->addColumn('actions', function ($row) {
                return '<div class="dropdown">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions <i class="ki-outline ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 edit-country" data-id="' . $row->id . '">Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-country btn btn-active-light-danger" data-id="' . $row->id . '">Delete</a>
                            </div>
                        </div>
                    </div>';
            })
            ->addIndexColumn()
            ->rawColumns(['icon', 'actions','flag'])
            ->make(true);
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = new Category();
            $category->setTranslation('name', 'en', $request->name_en);
            $category->setTranslation('name', 'ar', $request->name_ar);
            $category->setTranslation('slug', 'en', Str::slug($request->name_en));
            $category->setTranslation('slug', 'ar', Str::slug($request->name_ar));
            $category->save();

            if ($request->hasFile('icon')) {
                $category
                    ->addMediaFromRequest('icon')
                    ->usingFileName(Str::random(20) . '.' . $request->file('icon')->getClientOriginalExtension())
                    ->storingConversionsOnDisk('categories')
                    ->toMediaCollection('icon', 'categories');
            }

            return response()->json(['message' => 'Category added successfully.']);
        } catch (\Exception $e) {
            Log::error("Category creation error: " . $e->getMessage());
            return response()->json(['message' => 'Unexpected error.'], 500);
        }
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json([
            'id' => $category->id,
            'name_en' => $category->getTranslation('name', 'en'),
            'name_ar' => $category->getTranslation('name', 'ar'),
            'icon' => $category->getImageUrl(),
        ]);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            $category->setTranslation('name', 'en', $request->name_en);
            $category->setTranslation('name', 'ar', $request->name_ar);
            $category->setTranslation('slug', 'en', Str::slug($request->name_en));
            $category->setTranslation('slug', 'ar', Str::slug($request->name_ar));
            $category->save();

            if ($request->hasFile('icon')) {
                // حذف الصور القديمة من مجموعة 'icon' فقط
                $category->clearMediaCollection('icon');

                // إضافة الصورة الجديدة على الديسك 'categories' ضمن مجموعة 'icon'
                $category->addMediaFromRequest('icon')
                    ->usingFileName(Str::random(20) . '.' . $request->file('icon')->getClientOriginalExtension())
                    ->toMediaCollection('icon', 'categories');
            }

            return response()->json(['message' => 'Category updated successfully.']);
        } catch (\Exception $e) {
            Log::error("Category update error: " . $e->getMessage());
            return response()->json(['message' => 'Unexpected error.'], 500);
        }
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);


        if ($category->subCategories()->count() > 0) {
            return response()->json(['message' => 'Cannot delete category with subcategories.'], 400);
        }

        $category->clearMediaCollection('icon');
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.']);
    }
}
