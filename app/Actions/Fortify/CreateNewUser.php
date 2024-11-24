<?php

namespace App\Actions\Fortify;

use App\Models\Gurpeg;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use function Symfony\Component\Clock\now;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        if ($input['role'] === 'siswa') {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:20'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                ],
                'username' => 'required|min:5|max:25',
                'no_hp' => 'required|min:11|max:15',
                'nip' => 'required|min:18|max:20',
                'password' => $this->passwordRules(),
            ])->validate();

            $user = User::create([
                'name' => $input['name'],
                'username' => $input['username'],
                'email' => $input['email'],
                'role' => $input['role'],
                'password' => Hash::make($input['password']),
            ]);

            $user->assignRole($input['role']);

            Gurpeg::create([
                'user_id' => $user->id,
                'name' => $input['name'],
                'nip' => $input['nip'],
                'no_hp' => $input['no_hp'],
            ]);

            return $user;
        }else {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:20'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                ],
                'username' => 'required|min:5|max:25',
                'no_hp' => 'required|min:11|max:15',
                'nisn' => 'required|min:10|max:15|unique:siswas',
                'nis' => 'required|min:4|max:10|unique:siswas',
                'kelas' => 'required',
                'password' => $this->passwordRules(),
            ])->validate();

            $user = User::create([
                'name' => $input['name'],
                'username' => $input['username'],
                'email' => $input['email'],
                'role' => $input['role'],
                'password' => Hash::make($input['password']),
            ]);

            $user->assignRole($input['role']);

            $kelas = Kelas::firstOrCreate(
                ['name' => $input['kelas']],
                [
                    'name' => $input['kelas'],
                    'description' => "Kelas di tahun pelajaran " . now()->format('Y'),
                    'tahun_ajar' => now()->format('Y')
                ]
            );

            Siswa::create([
                'user_id' => $user->id,
                'name' => $input['name'],
                'nisn' => $input['nisn'],
                'nis' => $input['nis'],
                'kelas_id' => $kelas->id,
                'no_hp' => $input['no_hp'],
            ]);

            return $user;
        }
    }
}
