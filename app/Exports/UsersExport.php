<?php
// app/Exports/UsersExport.php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class UsersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::select(
            'id',
            'name',
            'email',
            'email_verified_at',
            'avatar',
            'status',
            'role',
            'created_at',
            'updated_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Email Verified At',
            'Avatar URL',
            'Status',
            'Role',
            'Created At',
            'Updated At',
        ];
    }
}
