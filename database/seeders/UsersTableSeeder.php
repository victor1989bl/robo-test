<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserMetadata;
use App\Services\Abstracts\UserServiceInterface;
use Database\Factories\UserMetadataFactory;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * UsersTableSeeder constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::transaction(function (){
            User::factory(10)
                ->create();

            $users = $this->userService->getAllUsers();

            $users->each(function(User $user){
                $metadata = UserMetadata::factory()
                    ->makeOne();

                $user->metadata()->save($metadata);
            });
        });
    }
}
