<?php

namespace App\Services;

use App\Models\Email;
use App\Models\Phone;
use App\Models\User;

/**
 *  Service for CRUD User
 */
class UserService
{
    /**
     * Store User from request data
     *
     * @param array $data
     */
    public function store(array $data)
    {
        $user = User::create($data);
        $user->save();
        $this->savePhones($user, $data['phones']);
        $this->saveEmails($user, $data['emails']);
    }

    /**
     * Update User from request data
     *
     * @param $id
     * @param array $data
     */
    public function update($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);

        $user->phones()->delete();
        $this->savePhones($user, $data['phones']);

        $user->emails()->delete();
        $this->saveEmails($user, $data['emails']);
    }

    /**
     * Save User Phones from request data
     *
     * @param User $user
     * @param array $phones
     */
    private function savePhones(User $user, array $phones)
    {
        foreach ($phones as $phone) {
            $user->phones()->save(
                new Phone(['phone_number' => $phone])
            );
        }
    }

    /**
     * Save User Emails from request data
     *
     * @param User $user
     * @param array $emails
     */
    private function saveEmails(User $user, array $emails)
    {
        foreach ($emails as $email) {
            $user->emails()->save(
                new Email(['email' => $email])
            );
        }
    }
}
