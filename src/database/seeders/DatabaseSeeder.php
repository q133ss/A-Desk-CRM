<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Timezone;
use App\Models\TransactionCategory;
use App\Models\TransactionItem;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DateTime;
use DateTimeZone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->alert('Начинаю Seed БД');

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

        $this->command->info('Добавляю роли');

        foreach ($roles as $slug => $data) {
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

        $this->command->info('Добавляю доступы');

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $this->command->info('Создаю пользователя');
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@email.net',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'phone' => '+7(111)111-11-11',
            'timezone_id' => Timezone::where('name', '(GMT +03:00) Europe/Moscow')->pluck('id')->first()
        ]);

        // Timezone

        $timezones = \DateTimeZone::listIdentifiers();

        $this->command->info('Начинаю создание временных зон');
        foreach ($timezones as $timezone) {
            $dateTime = new DateTime('now', new DateTimeZone($timezone));
            $offset = $dateTime->getOffset();

            $hours = sprintf("%02d", abs($offset / 3600));
            $minutes = sprintf("%02d", abs(($offset % 3600) / 60));
            $offsetString = 'GMT' . ($offset >= 0 ? " +" : " -") . $hours . ':' . $minutes;

            $formattedTimezone = "($offsetString) $timezone";

            DB::table('timezones')->insert([
                'name' => $formattedTimezone,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        function getMaxPosition($user_id)
        {
            $itemPos = TransactionItem::where('user_id', $user_id)->max('position');
            $groupPos = TransactionCategory::where('user_id', $user_id)->max('position');

            $itemPos = $itemPos !== null ? $itemPos : 0;
            $groupPos = $groupPos !== null ? $groupPos : 0;

            return max($itemPos, $groupPos) + 1;
        }

        $transactionGroups = [
            [
                'name' => 'Ввод денег в бизнес',
                'category' => 'income',
                'user_id' => $admin->id
            ],
            [
                'name' => 'Кредит',
                'category' => 'income',
                'user_id' => $admin->id
            ],
            [
                'name' => 'Ремонт квартир',
                'category' => 'income',
                'user_id' => $admin->id
            ],

            [
                'name' => 'Зарплата',
                'category' => 'consumption',
                'user_id' => $admin->id
            ],
            [
                'name' => 'Налоги',
                'category' => 'consumption',
                'user_id' => $admin->id
            ],
            [
                'name' => 'Офис',
                'category' => 'consumption',
                'user_id' => $admin->id
            ],
        ];

        $this->command->info('Начинаю добавление групп статей операций');

        foreach ($transactionGroups as $group)
        {
            $group['position'] = getMaxPosition($admin->id);
            TransactionCategory::create($group);
        }

        $transationItems = [
            [
                'name' => "Аванс по квартире",
                'group_id' => TransactionCategory::where('name', 'Ремонт квартир')->pluck('id')->first(),
                'description' => 'Аванс',
                'category' => 'income',
                'type' => 'income_primary_activity'
            ],
            [
                'name' => "Постоплата по квартире",
                'group_id' => TransactionCategory::where('name', 'Ремонт квартир')->pluck('id')->first(),
                'description' => 'Постоплата по квартире',
                'category' => 'income',
                'type' => 'income_primary_activity'
            ],

            [
                'name' => "Бригада оклад",
                'group_id' => TransactionCategory::where('name', 'Зарплата')->pluck('id')->first(),
                'description' => 'Оклад',
                'category' => 'consumption',
                'type' => 'primary_activity',
            ],
            [
                'name' => "Бригада процент",
                'group_id' => TransactionCategory::where('name', 'Зарплата')->pluck('id')->first(),
                'description' => 'Процент',
                'category' => 'consumption',
                'type' => 'primary_activity',
            ],
            [
                'name' => "Налог на имущество",
                'group_id' => TransactionCategory::where('name', 'Налоги')->pluck('id')->first(),
                'description' => 'Налог',
                'category' => 'consumption',
                'type' => 'primary_activity',
            ],
            [
                'name' => "НДС",
                'group_id' => TransactionCategory::where('name', 'Налоги')->pluck('id')->first(),
                'description' => 'Налог',
                'category' => 'consumption',
                'type' => 'primary_activity',
            ],
            [
                'name' => "Налог на фонд оплаты труда",
                'group_id' => TransactionCategory::where('name', 'Налоги')->pluck('id')->first(),
                'description' => 'Налог',
                'category' => 'consumption',
                'type' => 'primary_activity',
            ],
        ];

        $this->command->info('Начинаю добавление статей операций');

        foreach ($transationItems as $item)
        {
            $item['user_id'] = $admin->id;
            $item['position'] = getMaxPosition($admin->id);
            TransactionItem::create($item);
        }

        $this->command->alert('Seed завершен!');
    }
}
