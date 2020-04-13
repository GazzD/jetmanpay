<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default permissions
        $permissions = array();
        $permissions[] = Permission::create(['name' => 'create-users']);
        
        // Assing manager's permissions
        $role = Role::findByName('MANAGER');
        $role->syncPermissions($permissions);
        
        // Assing client's permissions
        $permission = Permission::findByName('create-users');
        $role = Role::findByName('CLIENT');
        $role->syncPermissions($permission);
        
        
        
        // An empty array of stored permission IDs
//         $permission_ids = []; 
//         // Iterate though all routes
//         foreach (\Route::getRoutes() as $route)
//         {
//             // Get route action
//             $action = $route->getActionname();
//             // Separating controller and method
//             $_action = explode('@',$action);
            
//             $controller = $_action[0];
//             $method = end($_action);
            
//             // Check if this permission is already exists
//             $permission_check = Permission::where(['controller'=>$controller,'method'=>$method])
//                 ->first()
//             ;
//             if(!$permission_check){
//                 $permission = new Permission();
//                 $permission->controller = $controller;
//                 $permission->method = $method;
//                 $permission->save();
//                 // Add stored permission id in array
//                 $permission_ids[] = $permission->id;
//             }
//         }
        // Find manager role.
//         $admin_role = Role::where('name','MANAGER')->first();
        
        // Attach all permissions to admin role
//         $admin_role->permissions()->attach($permission_ids);
        
    }
}
