<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\RessortCategory;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\Guest;
use App\Models\RessortWorkShift;
use App\Models\User;
use App\Models\Person;
use App\Models\Ressort;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $account = Account::create(['name' => 'Acme Corporation']);

        User::factory()->create([
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'secret',
            'owner' => true,
        ]);

        User::factory(1)->create(['account_id' => $account->id]);

        Guest::factory(1)->create(['account_id' => $account->id]);

        Person::factory(1)->create(['account_id' => $account->id]);

        RessortCategory::factory(1)->create(['account_id' => $account->id]);

        //RessortWorkShift::factory(4)->create(['account_id ']);



        $ressortCategory = RessortCategory::
        create([
            'account_id' => $account->id,
            'name' => 'Camping',
        ]);
        Ressort::factory(1)
            ->create([
                'account_id' => $account->id,
                'ressort_category_id' => $ressortCategory->id,
            ]);


        $ressortCategory = RessortCategory::
        create([
            'account_id' => $account->id,
            'name' => 'Parkplatz',
        ]);
        Ressort::factory(1)
            ->create([
                'account_id' => $account->id,
                'ressort_category_id' => $ressortCategory->id,
            ]);


        $ressortCategory = RessortCategory::
        create([
            'account_id' => $account->id,
            'name' => 'Grillplatz',
        ]);
        Ressort::factory(1)
            ->create([
                'account_id' => $account->id,
                'ressort_category_id' => $ressortCategory->id,
            ]);


        $ressortCategory = RessortCategory::
        create([
            'account_id' => $account->id,
            'name' => 'Toiletten',
        ]);
        $ressorts = Ressort::factory(1)
            ->create([
                'account_id' => $account->id,
                'ressort_category_id' => $ressortCategory->id,
            ]);




        foreach ($ressorts as $ressort){
            $ressort_work_shift = RessortWorkShift::factory(1)
            ->create([
                'account_id' => $account->id,
                'ressort_id' => $ressort->id,
            ]);
        }







        /*
            $ressorts = Ressort::factory(100)
                ->create([
                    'account_id' => $account->id
                ]);
            Contact::factory(100)
                ->create([
                    'account_id' => $account->id
                ])
                ->each(function ($contact) use ($ressorts) {
                    $contact->update([
                        'ressort_id' => $ressorts->random()->id
                    ]);
                });
        */


        $organizations = Organization::factory(1)
            ->create([
                'account_id' => $account->id
            ]);
        Contact::factory(100)
            ->create([
                'account_id' => $account->id
            ])
            ->each(function ($contact) use ($organizations) {
                $contact->update([
                    'organization_id' => $organizations->random()->id
                ]);
            });
    }
}
