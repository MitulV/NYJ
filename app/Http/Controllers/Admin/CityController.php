<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('City_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cities = City::all();

        return view('admin.cities.index', compact('cities'));
    }

    public function create()
    {
        abort_if(Gate::denies('City_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cities.create');
    }

    public function store(Request $request)
    {
        abort_if(Gate::denies('City_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // Add other validation rules as needed
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $city = City::create($request->all());

        return redirect()->route('admin.cities.index');
    }

    public function edit(City $city)
    {
        abort_if(Gate::denies('City_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cities.edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        abort_if(Gate::denies('City_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // Add other validation rules as needed
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $city->update($request->all());

        return redirect()->route('admin.cities.index');
    }

    public function show(City $city)
    {
       abort_if(Gate::denies('City_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.cities.show', compact('city'));
    }

    public function destroy(City $city)
    {
        abort_if(Gate::denies('City_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $city->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        abort_if(Gate::denies('City_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $validator = Validator::make($request->all(), [
            'ids'   => 'required|array',
            'ids.*' => 'exists:amenities,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        City::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
