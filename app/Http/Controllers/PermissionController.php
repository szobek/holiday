<?php

namespace App\Http\Controllers;

use App\Permission;
use App\PermissionUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * @author norbi
     * @return
     */
    public function listPermissionsView(){
        $permissions = Permission::all();
        return view('permissions/index', compact('permissions'));
    }

    /**
     * @author norbi
     * @return
     */
    public function editPermissionView($id){
        $permission = Permission::find($id);
        if($permission === null) abort(404);
        return view('permissions/detail', compact('permission'));
    }

    /**
     * @author norbi
     * @return
     */
    public function editPermission(Request $request, $id){
        if(!isset($request->id ) || $request->id !== $id ) abort(419);
        $permission = Permission::find($request->id );

        $permission->name = $request->name;
        $permission->description = $request->description;
        $permission->save();

        return redirect()->back();
    }

    /**
     * beállítja egy user jogait - view
     * @author norbi
     * @return
     */
    public function contactUserToPermissionView($id){
        if(!cp(5, Auth::user()->permission_listIds)) return redirect('/');


        if(!isset($id)) abort(404);
        $user = User::find($id);

        if($user === null) abort(404);

        $permissions_db = Permission::all();
        $permissions = [];
        foreach ($permissions_db as $permission) {
            if(!in_array($permission->id, $user->permission_list_ids))
                $permissions[] = $permission;
        }



        return view('permissions/contact_user', compact('permissions', 'user'));

    }

    /**
     * @author norbi
     * @return
     */
    public function addPermissionToUser($user_id, $permission_id){
        if(!cp(5, session('permissions'))) return abort(403, 'Http/Controllers/PermissionController.php:79');
        $permission = Permission::find($permission_id);
        if($permission === null)  return redirect()->back();

        $user = User::find($user_id);
        if($user === null)  return redirect()->back();


        if(PermissionUser::where('user_id',$user_id)->where('permission_id', $permission_id)->count() === 0) {
            PermissionUser::create([
                "user_id" => $user_id,
                "permission_id" => $permission_id,
            ]);
        }

        else
            return redirect()->back();

        return redirect()->back();
    }

    /**
     * @author norbi
     * @return
     */
    public function deletePermissionFromUser($user_id, $permission_id){

        $permission = Permission::find($permission_id);
        if($permission === null)  return redirect()->back();

        $user = User::find($user_id);
        if($user === null)  return redirect()->back();

        $request = PermissionUser::where('user_id',$user_id)->where('permission_id', $permission_id);
        if($request->count() > 0) {
            $request->delete();
        } else {
            return redirect()->back();
        }


        return redirect()->back();

    }
}
