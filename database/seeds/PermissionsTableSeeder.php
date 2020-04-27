<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

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
        Permission::create(['name' => 'admin-users']);
        Permission::create(['name' => 'admin-planes']);
        Permission::create(['name' => 'admin-recharges']);
        Permission::create(['name' => 'admin-payments']);
        Permission::create(['name' => 'admin-pending-payments']);
        Permission::create(['name' => 'admin-send-payments']);
        Permission::create(['name' => 'admin-payments-by-airline']);
        Permission::create(['name' => 'admin-payments-manual']);
        Permission::create(['name' => 'admin-claims']);
        Permission::create(['name' => 'admin-dosas']);
        Permission::create(['name' => 'admin-settings']);
        Permission::create(['name' => 'admin-documents']);
        
        $managerPermissions = [
            'admin-users',
            'admin-payments',
            'admin-pending-payments',
            'admin-send-payments',
            'admin-payments-by-airline',
            'admin-payments-manual',
            'admin-claims',
            'admin-settings',
            'admin-documents'
        ];
        
        $operatorPermissions = [
            'admin-payments',
            'admin-pending-payments',
            'admin-send-payments',
            'admin-payments-by-airline',
            'admin-payments-manual',
            'admin-claims',
            'admin-settings',
            'admin-documents'
        ];
        
        $clientPermissions = [
            'admin-planes',
            'admin-recharges',
            'admin-users',
            'admin-payments',
            'admin-dosas',
            'admin-settings',
            'admin-documents'
        ];
        
        $treasurerPermissions = [
            'admin-payments',
            'admin-dosas',
            'admin-settings',
            'admin-documents'
        ];
        
        $treasurer2Permissions = [
            'admin-payments',
            'admin-dosas',
            'admin-settings',
            'admin-documents'
        ];
        
        $reviewerPermissions = [
            'admin-recharges',
            'admin-settings',
            'admin-documents'
        ];
        
        $staffPermissions = [
            'admin-settings',
            'admin-documents'
        ];
        
        // Assing manager's permissions
        $role = Role::findByName('MANAGER');
        $permissions = Permission::whereIn('name', $managerPermissions)->get();
        $role->syncPermissions($permissions);
        
        // Assing operator's permissions
        $role = Role::findByName('OPERATOR');
        $permissions = Permission::whereIn('name', $operatorPermissions)->get();
        $role->syncPermissions($permissions);
        
        // Assing client's permissions
        $role = Role::findByName('CLIENT');
        $permissions = Permission::whereIn('name', $clientPermissions)->get();
        $role->syncPermissions($permissions);
        
        // Assing client treasurer1's permissions
        $role = Role::findByName('TREASURER1');
        $permissions = Permission::whereIn('name', $treasurerPermissions)->get();
        $role->syncPermissions($permissions);
        
        // Assing client treasurer2's permissions
        $role = Role::findByName('TREASURER2');
        $permissions = Permission::whereIn('name', $treasurer2Permissions)->get();
        $role->syncPermissions($permissions);
        
        // Assing reviewer's permissions
        $role = Role::findByName('REVIEWER');
        $permissions = Permission::whereIn('name', $reviewerPermissions)->get();
        $role->syncPermissions($permissions);
        
        // Assing staff's permissions
        $role = Role::findByName('STAFF');
        $permissions = Permission::whereIn('name', $staffPermissions)->get();
        $role->syncPermissions($permissions);
        
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
