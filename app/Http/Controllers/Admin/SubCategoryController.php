<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;


class SubCategoryController extends Controller
{

    public function index()
    {
        return view('admin.management.subcategories.index');
    }

    public function data(Request $request)
    {
//        data table
        $query = \App\Models\Category::query();

        if ($request->search) {
            $search = $request->search;
            $search_by = $request->get('search_by', 'name');
            $query->where($search_by, 'ilike', "%{$search}%");
        }

        // Apply sorting
        $sortField = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_dir', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $perPage = $request->input('per_page', 10);
        $categories = $query->paginate($perPage);

        return response()->json([
            'data' => $categories,
            'message' => 'Categories retrieved successfully',
            'success' => true,
            'status' => 200
        ]);
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
        return view('admin.categories.show', compact('id'));
    }

}
