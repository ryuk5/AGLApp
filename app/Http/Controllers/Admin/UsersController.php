<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Gate;
use App\User;
use App\Role;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /* 
     *   él fonction téjbéd tous les utilisateures bch ils seront affiché fél users managment page pour les admins
     */
     
    public function index()
    {
        $users = User::all();
        return view('admin.users.index')->with('users', $users); //le passage de la variable users lél view
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    
    /*
     * Gate pour protéger la fonction éli avec la quelle on édite les users (sécurité)
     */

    public function edit(User $user)
    {
        if(Gate::denies('edit-users'))
        {
            return redirect(route('admin.users.index'));
        }
        
        
        $roles = Role::all();
        return view('admin.users.edit')->with([
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    
    /**
     * él fonction héthi hiya éli bch ta3méllél update fél base de donnée
     */
    public function update(Request $request, User $user)
    {
        //dd($request);
        $user->role_id = $request->role;
        $user->name = $request->name;
        $user->email = $request->email;
        if($user->save())
        {
            $request->session()->flash('success', $user->name . ' has been updated');
        }
        else
        {
            $request->session()->flash('error', 'There was an error updating the user');
        }
            

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    
    /*
     * Gate pour protéger la fonction éli avec la quelle on édite les users (sécurité)
     */

    public function destroy(User $user)
    {
        if(Gate::denies('delete-users'))
        {
            return redirect(route('admin.users.index'));
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
