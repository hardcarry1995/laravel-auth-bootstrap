<?php
namespace App\Repositories;

use App\Models\User;
use App\Repositories\IUserRepository;
use Illuminate\Support\Facades\Hash;

class UserRepository implements IUserRepository
{   
    protected $user = null;

    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById($id)
    {
        return User::find($id);
    }

    public function getUserByName($name)
    {
        return User::where("name", $name)->get();
    }

    public function verify($email, $password)
    {   
        $user = User::where("email", $email)->first();

        if(!$user || !Hash::check($password, $user->password))
            return NULL;
        return $user;
    }

    public function createOrUpdate( $id = null, $collection = [] )
    {   
        if(is_null($id)) {
            $user = new User;
            $user->name = $collection['name'];
            $user->email = $collection['email'];
            $user->password = Hash::make('password');
            return $user->save();
        }
        $user = User::find($id);
        $user->name = $collection['name'];
        $user->email = $collection['email'];
        return $user->save();
    }
    
    public function deleteUser($id)
    {
        return User::find($id)->delete();
    }
}