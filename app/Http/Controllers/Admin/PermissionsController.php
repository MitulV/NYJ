<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPermissionRequest;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PermissionsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('User_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = Permission::all();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        abort_if(Gate::denies('User_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        abort_if(Gate::denies('User_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission = Permission::create($request->all());

        return redirect()->route('admin.permissions.index');
    }

    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('User_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->all());

        return redirect()->route('admin.permissions.index');
    }

    public function show(Permission $permission)
    {
        abort_if(Gate::denies('User_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.permissions.show', compact('permission'));
    }

    public function destroy(Permission $permission)
    {
        abort_if(Gate::denies('User_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permission->delete();

        return back();
    }

    public function massDestroy(MassDestroyPermissionRequest $request)
    {
        abort_if(Gate::denies('User_Management'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Permission::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
