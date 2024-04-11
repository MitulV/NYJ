<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('Category_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        abort_if(Gate::denies('Category_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('Category_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // Add other validation rules as needed
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $category = Category::create($request->all());

        return redirect()->route('admin.categories.index');
    }

    public function edit(Category $category)
    {
        abort_if(Gate::denies('Category_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        abort_if(Gate::denies('Category_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // Add other validation rules as needed
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category->update($request->all());

        return redirect()->route('admin.categories.index');
    }

    public function show(Category $category)
    {
        abort_if(Gate::denies('Category_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.categories.show', compact('category'));
    }

    public function destroy(Category $category)
    {
        abort_if(Gate::denies('Category_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        abort_if(Gate::denies('Category_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $validator = Validator::make($request->all(), [
            'ids'   => 'required|array',
            'ids.*' => 'exists:amenities,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        Category::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
