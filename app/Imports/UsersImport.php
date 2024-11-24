<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;

class UsersImport implements ToModel, WithHeadingRow, WithProgressBar
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            "username"=> $row["username"],
            "email"=> $row["email"],
            "password"=> bcrypt($row["password"]),
        ]);
    }

    public function rules(): array
    {
        return [
            'username' => 'required|regex:/^\S*$/u|min:5',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ];
    }
}
