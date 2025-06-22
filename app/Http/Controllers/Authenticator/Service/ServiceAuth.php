<?php

namespace App\Http\Controllers\Authenticator\Service;

use App\Helpers\UploadImage;
use App\Http\Controllers\Authenticator\Repository\AuthRepository;
use Illuminate\Support\Facades\Hash;

class ServiceAuth
{
    private string $pathImageUsers = 'user_images';
    public function __construct(
        protected AuthRepository $authRepository
    )
    {
    }

    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        if (isset($data['photo'])) {
            $data['photo'] = UploadImage::execute($data['photo'], $this->pathImageUsers);
        }

        return $this->authRepository->createNew($data);
    }

    public function updateUser($user, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if (isset($data['photo'])) {
            $data['photo'] = UploadImage::execute(
                file: $data['photo'],
                directoryName: $this->pathImageUsers,
                pathExclude: $user->photo ?? ''
            );
        }

        return $this->authRepository->update($user, $data);
    }
}
