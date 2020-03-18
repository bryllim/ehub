<?php

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
        // Departments

        $departments = [
            ['name' => "Accounting"],
            ['name' => "Registrar"],
            ['name' => "Center for Advancement and Students' Life"],
            ['name' => "Human Resources and Development Office"],
            ['name' => "Dean's Office"],
            ['name' => "Associate Dean's Office / MEU"],
            ['name' => "Facilities Engineering"],
            ['name' => "Facilities Cleaning"],
            ['name' => "Facilities Libary"],
            ['name' => "Security and Safety Department"],
            ['name' => "Admin. Office / VPLA"],
            ['name' => "Admin. Office / VPFA"],
            ['name' => "Information and Communications Technology Department"],
            ['name' => "Compliance and Audit"],
        ];

        DB::table('departments')->insert($departments);

        DB::table('users')->insert([
            'name' => "Rosemarie Español",
            'email' => "rcespanol@gcm.edu.ph",
            'password' => Hash::make('password'),
            'position' => "Vice President",
            'department_id' => "10",
        ]);

        DB::table('users')->insert([
            'name' => "Bryl Kezter Lim",
            'email' => "bklim@gcm.edu.ph",
            'password' => Hash::make('password'),
            'position' => "Software Engineer",
            'department_id' => "11",
        ]);

        DB::table('users')->insert([
            'name' => "Cris Lawrence Adrian Militante",
            'email' => "clamilitante@gcm.edu.ph",
            'password' => Hash::make('password'),
            'position' => "Director",
            'department_id' => "11",
        ]);

        DB::table('users')->insert([
            'name' => "Nichelle Faye Galicia",
            'email' => "nfgalicia@gcm.edu.ph",
            'password' => Hash::make('password'),
            'position' => "Executive Secretary",
            'department_id' => "10",
        ]);
    }
}
