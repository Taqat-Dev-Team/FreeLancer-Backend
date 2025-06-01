<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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

        if ($request->has('search')) {
            $search = strtolower($request->search); // Convert search term to lowercase
            $categories = $categories->where(function ($query) use ($search) {
                $query->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.en'))) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.ar'))) LIKE ?", ["%{$search}%"]);
            });
        }


        return DataTables::of($categories)
            ->addColumn('icon', function ($row) {
                return '<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                        <a href="#">
                            <div class="symbol-label">
                                <img src="' . url($row->getImage()) . '" alt="Icon" class="w-100">
                            </div>
                        </a>
                    </div>';
            })
            ->editColumn('sub_categories_count', function ($row) {
                return '<div class="badge badge-light-info fw-bold rounded text-center">' . $row->sub_categories_count . '</div>';
            })
            ->addColumn('actions', function ($row) {
                return '<div class="dropdown">
                        <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions <i class="ki-outline ki-down fs-5 ms-1"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 edit-category" data-id="' . $row->id . '">Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 delete-category btn btn-active-light-danger" data-id="' . $row->id . '">Delete</a>
                            </div>
                        </div>
                    </div>';
            })
            ->rawColumns(['icon', 'actions', 'sub_categories_count'])
            ->make(true);
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'name_ar' => [
                    'required', 'string', 'max:255',
                    function ($attribute, $value, $fail) {
                        if (\App\Models\Category::where('name->ar', $value)->exists()) {
                            $fail('This Arabic name already exists.');
                        }
                    },
                ],
                'name_en' => [
                    'required', 'string', 'max:255',
                    function ($attribute, $value, $fail) {
                        if (\App\Models\Category::where('name->en', $value)->exists()) {
                            $fail('This English name already exists.');
                        }
                    },
                ],
                'icon' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            ], [
                'name_ar.required' => 'The Arabic name is required.',
                'name_ar.string' => 'The Arabic name must be a string.',
                'name_ar.max' => 'The Arabic name may not be greater than 255 characters.',

                'name_en.required' => 'The English name is required.',
                'name_en.string' => 'The English name must be a string.',
                'name_en.max' => 'The English name may not be greater than 255 characters.',

                'icon.required' => 'The icon is required.',
                'icon.image' => 'The file must be an image.',
                'icon.mimes' => 'Supported icon formats are: jpeg, png, jpg, gif, svg.',
                'icon.max' => 'The icon size may not exceed 2MB.',
            ]);


            if ($validator->fails()) {
                throw new ValidationException($validator);
            }


            $iconPath = null;
            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('categories', 'public');
            }

            // Create the new category record in the database

            $category = new Category();
            $category->setTranslation('name', 'en', $request->name_en);
            $category->setTranslation('name', 'ar', $request->name_ar);
            $category->setTranslation('slug', 'ar', Str::slug($request->name_ar));
            $category->setTranslation('slug', 'en', Str::slug($request->name_en));
            $category->icon = $iconPath;
            $category->save();


            // Return a success JSON response
            return response()->json(['message' => 'Category added successfully!'], 200);

        } catch (ValidationException $e) {
            // Return JSON response for validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Log any unexpected errors for debugging
            Log::error('Error adding category: ' . $e->getMessage());
            // Return a generic error JSON response
            return response()->json(['message' => 'An unexpected error occurred. Please try again.'], 500);
        }
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

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'name_ar' => [
                    'required',
                    'string',
                    'max:255',
                    function ($attribute, $value, $fail) use ($category) {
                        if (Category::where('id', '!=', $category->id)->where('name->ar', $value)->exists()) {
                            $fail('This Arabic name already exists.');
                        }
                    },
                ],
                'name_en' => [
                    'required',
                    'string',
                    'max:255',
                    function ($attribute, $value, $fail) use ($category) {
                        if (Category::where('id', '!=', $category->id)->where('name->en', $value)->exists()) {
                            $fail('This English name already exists.');
                        }
                    },
                ],
                // Icon is no longer 'required' for update, but if present, must be an image
                'icon' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            ], [
                'name_ar.required' => 'The Arabic name is required.',
                'name_ar.string' => 'The Arabic name must be a string.',
                'name_ar.max' => 'The Arabic name may not be greater than 255 characters.',

                'name_en.required' => 'The English name is required.',
                'name_en.string' => 'The English name must be a string.',
                'name_en.max' => 'The English name may not be greater than 255 characters.',

                'icon.image' => 'The file must be an image.',
                'icon.mimes' => 'Supported icon formats are: jpeg, png, jpg, gif, svg.',
                'icon.max' => 'The icon size may not exceed 2MB.',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Handle icon file upload (if a new one is provided)
            if ($request->hasFile('icon')) {
                // Delete old icon if it exists
                if ($category->icon && Storage::disk('public')->exists($category->icon)) {
                    Storage::disk('public')->delete($category->icon);
                }
                $iconPath = $request->file('icon')->store('categories_icons', 'public');
                $category->icon = $iconPath; // Update icon path
            }

            // Update translatable 'name' attributes
            $category->setTranslation('name', 'en', $request->name_en);
            $category->setTranslation('name', 'ar', $request->name_ar);

            // Update translatable 'slug' attributes
            $category->setTranslation('slug', 'ar', Str::slug($request->name_ar));
            $category->setTranslation('slug', 'en', Str::slug($request->name_en));

            $category->save(); // Save all changes

            // Return a success JSON response
            return response()->json(['message' => 'Category updated successfully!'], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating category: ' . $e->getMessage());
            return response()->json(['message' => 'An unexpected error occurred. Please try again.'], 500);
        }
    }


    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Check if the category has subcategories
        if ($category->subCategories()->count() > 0) {
            return response()->json(['message' => 'Cannot delete category with subcategories.'], 400);
        }
        if ($category->icon && Storage::exists($category->icon)) {
            Storage::delete($category->icon);
        }

        // Delete category from database
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.']);
    }


}
