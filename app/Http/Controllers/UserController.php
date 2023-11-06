<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Nette\Utils\DateTime;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $this->allUsers($request->user()->id);

        return response([
            'data' => UserResource::collection($users)
        ]);
    }

    public function authUser(Request $request)
    {       
        $authUser = $request->user();
        $user = $this->oneUser($authUser->id);
        $userData = UserResource::collection($user);
        return response($userData[0]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'role_id' => 'required|int',
            'address' => 'string',
            'phone_number' => 'string',
            'role_id' => 'required|int',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ]
        ]);

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'role_id' => $data['role_id'],
            'email' => $data['email'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'password' => bcrypt($data['password']),
            'image_url' => 'images/avatars/default-avatar.png',
        ]);

        $user['id'] = $user->id;

        $users = $this->allUsers($request->user()->id);

        return response([
            'status' => 'Added',
            'current_user' => $user,
            'data' => UserResource::collection($users)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $resource = User::find($id);

        if (!$resource) {
            return response()->json(['message' => 'Resource not found'], 404);
        }
        
        $user = $this->oneUser($id);

        return response([
            'status' => 'Updated',
            'current_user' => UserResource::collection([$user[0]])
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email,'.$id,
            'role_id' => 'required|int',
            'address' => 'string',
            'phone_number' => 'string',
            'role_id' => 'required|int'
        ]);

        $resource = User::findOrFail($id);

        $resource->update($validatedData);

        $users = $this->allUsers($request->user()->id);

        return response([
            'status' => 'Updated',
            'current_user' => $resource,
            'data' => UserResource::collection($users)
        ]);
    }

    public function profile(Request $request, string $id) 
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email,'.$id,
            'phone_number' => 'string',
            'address' => 'string'
        ]);

        // Check if image was given and save on local file system
        if (isset($request['image'])) {
            $relativePath = $this->saveImage($request['image']);
            $validatedData['image_url'] = $relativePath;

            // If there is an old image, delete it
            if ($user->image_url) {
                $absolutePath = public_path($user->image_url);
                File::delete($absolutePath);
            }
        }

        // $user->update($validatedData);

        $user->update($validatedData);

        // Check if the update was successful
        if ($user->wasChanged()) {
            return response()->json(['message' => 'Save changes!'], 200);
        } else {
            return response()->json(['message' => 'Nothing change!'], 200);
        }
    }


    public function lockUser(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'locked' => 'required|boolean'
        ]);

        $resource = User::findOrFail($id);

        $resource->update($validatedData);

        // Check if the update was successful
        if ($resource->wasChanged()) {
            return response()->json(['message' => 'User account locked/unlocked successfully'], 200);
        } else {
            return response()->json(['message' => 'No changes made to the user account'], 200);
        }
    }

    public function changePassword(Request $request, string $id) 
    {
        $validatedData = $request->validate([
            'current_password' => 'required',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols()
            ]
        ]);

        $user = User::findOrFail($id);

        // Verify the current password before updating
        if (!Hash::check($validatedData['current_password'], $user->password)) {
            return response()->json(['errors' => [ 'error' => ['Current password does not match.']]], 422);
        }  

        $user->update([
            'password' => Hash::make($validatedData['password'])
        ]);

        // Check if the update was successful
        if ($user->wasChanged()) {
            return response()->json(['message' => 'Password changed successfully'], 200);
        } else {
            return response()->json(['message' => 'No changes!'], 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function allUsers($id){
        $users = User::query()
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', '!=', $id)
            ->orderBy('users.created_at', 'ASC')
            ->get(['users.*', 'roles.role as role']);

        return $users;
    }

    private function oneUser($id) {
        $user = User::query()
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', $id) // Corrected: specify 'users.id'
            ->get(['users.*', 'roles.role as role']);
        return $user;
    }

    private function saveImage($image)
    {
        // // Check if image is valid base64 string
        // if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
        //     // Take out the base64 encoded text without mime type
        //     $image = substr($image, strpos($image, ',') + 1);
        //     // Get file extension
        //     $type = strtolower($type[1]); // jpg, png, gif

        //     // Check if file is an image
        //     if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
        //         throw new \Exception('invalid image type');
        //     }
        //     $image = str_replace(' ', '+', $image);
        //     $image = base64_decode($image);

        //     if ($image === false) {
        //         throw new \Exception('base64_decode failed');
        //     }
        // } else {
        //     throw new \Exception('did not match data URI with image data');
        // }


        // Check if image is a valid base64 string
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            // Take out the base64 encoded text without the MIME type
            $image = substr($image, strpos($image, ',') + 1);
            // Get file extension
            $type = strtolower($type[1]); // jpg, png, gif

            // Check if the file is an image
            if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                throw new \Exception('Invalid image type');
            }

            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new \Exception('base64_decode failed');
            }

            // Check if the file size is within the allowed limit (500KB)
            // $maxFileSize = 500 * 1024; // 500KB in bytes
            // if (strlen($image) > $maxFileSize) {
            //     throw new \Exception('File size exceeds the maximum allowed limit.');
            // }
        } else {
            throw new \Exception('Did not match data URI with image data');
        }


        $dir = 'images/';
        $file = Str::random() . '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }


}
