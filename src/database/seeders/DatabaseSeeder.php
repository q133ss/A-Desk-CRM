<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            'owner' => [
                'name' => 'Владелец аккаунта',
                'description' => 'Пользователь, обладающий всеми правами администратора, включая возможность управлять другими владельцами аккаунта'
            ],
            'admin' => [
                'name' => 'Администратор',
                'description' => 'Пользователь, обладающий полным доступом ко всем деньгам, проектам и отчетам, настройкам бизнеса, и управлению правами других пользователей (кроме владельцев аккаунта)'
            ],
            'custom' => [
                'name' => 'Ограниченный доступ',
                'description' => 'Пользователь с индивидуальными правами доступа, установленными администратором или владельцем аккаунта.'
            ]
        ];

        foreach ($roles as $slug => $data){
            Role::create([
                'slug' => $slug,
                'name' => $data['name'],
                'description' => $data['description']
            ]);
        }

        $permissions = [
            ['name' => 'Доступ к счетам', 'slug' => 'accounts'],
            ['name' => 'Доступ к проектам', 'slug' => 'projects'],
            ['name' => 'Доступ к бюджетам', 'slug' => 'budgets'],
            ['name' => 'Доступ к контрагентам', 'slug' => 'counterparties'],
            ['name' => 'Разрешить выставлять счета на оплату', 'slug' => 'allow_payment'],
            ['name' => 'Доступ к отчётам и графикам', 'slug' => 'reports_and_graphs'],
            ['name' => 'Доступ к балансу', 'slug' => 'balance'],
            ['name' => 'Доступ к кредитам', 'slug' => 'credits'],
            ['name' => 'Доступ к основным средствам', 'slug' => 'fixed_assets'],
            ['name' => 'Доступ к настройкам', 'slug' => 'settings'],
            ['name' => 'Доступ к запасам', 'slug' => 'stocks'],
            ['name' => 'Доступ к согласованию платежей', 'slug' => 'payment_approval'],
            ['name' => 'Импорт данных', 'slug' => 'import_data'],
            ['name' => 'Экспорт данных', 'slug' => 'export_data'],
            ['name' => 'Редактирование данных', 'slug' => 'edit_data'],
            ['name' => 'Удаление данных', 'slug' => 'delete_data']
        ];

        foreach ($permissions as $permission){
            Permission::create($permission);
        }

        User::create([
            'name' => 'admin',
            'email' => 'admin@email.net',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'phone' => '+7(111)111-11-11'
        ]);
    }
}
