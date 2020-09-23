<?php

use Illuminate\Database\Seeder;

class MemberPositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Member_Position')->insert([
            'position' => 'Big Boss',
            'privilege' => 3,
            'description' => 'Has full admin rights to the website for troubleshooting and development purposes.',
            'created_at' => '2019-09-22 18:19:12',
//            'updated_at' => '2019-09-22 18:19:12',
            'email' => 'jgwesterfield@gmail.com'
        ]);

        DB::table('Member_Position')->insert([
            'position' => 'Development Director',
            'privilege' => 0,
            'description' => 'Works on grant writing, meeting with people who are interested in large monetary donations, setting up profit shares, going to Aggie Moms Club meetings, Sully donations, and help work towards making sure the 12th Can is financially secure',
            'created_at' => '2019-09-22 18:02:40',
//            'updated_at' => '2019-09-22 18:02:40',
            'email' => '12thcan.development@gmail.com'
        ]);

        DB::table('Member_Position')->insert([
            'position' => 'Public Relations Director',
            'privilege' => 0,
            'description' => 'Works on communication and marketing for the 12th Can through various methods such as distributing mass emails, promoting on social media, and designing promotional materials.',
            'created_at' => '2019-09-22 18:02:50',
//            'updated_at' => '2019-09-22 18:02:50',
            'email' => '12thcan.publicrelations@gmail.com'
        ]);

        DB::table('Member_Position')->insert([
            'position' => 'Finance Director',
            'privilege' => 0,
            'description' => 'Keeps a ledger, reconciles SOFC and Foundation accounts, SGA allocations, dues, Sully statue money, seeks out donations, and promotes the financial security and future of the 12 Can.',
            'created_at' => '2019-09-22 18:03:40',
//            'updated_at' => '2019-09-22 18:03:40',
            'email' => '12thcan.finance@gmail.com'
        ]);

        DB::table('Member_Position')->insert([
            'position' => 'Donations Director',
            'privilege' => 0,
            'description' => 'In charge of coordinating all food donations. Schedules the drop off times and asks patrons to fill out a form to keep basic personal info (email addresses and phone numbers). Also records the quantities of food donations so that the 12th Can can keep a running inventory.',
            'created_at' => '2019-09-22 18:03:40',
//            'updated_at' => '2019-09-22 18:03:40',
            'email' => '12thcan.donation@gmail.com'
        ]);

        DB::table('Member_Position')->insert([
            'position' => 'Facilities Director',
            'privilege' => 1,
            'description' => 'In charge of buying food to make sure the pantry is stocked. Also in charge of sorting through all food that comes into the pantry ensure food safety. Also directs other members on how to operate the pantry and restock during pantry openings.',
            'created_at' => '2019-09-22 18:11:09',
//            'updated_at' => '2019-09-22 18:11:09',
            'email' => '12thcan.facilities@gmail.com'
        ]);

        DB::table('Member_Position')->insert([
            'position' => 'Assistant Director',
            'privilege' => 1,
            'description' => 'In charge of all internal affairs of the 12th Can, including, but not limited to, managing and supporting all the executive directors and members as well as maintaining relationships with other on-campus entities.',
            'created_at' => '2019-09-22 18:11:09',
//            'updated_at' => '2019-09-22 18:11:09',
            'email' => '12thcan.ad@gmail.com'
        ]);

/*        DB::table('Member_Position')->insert([
            'position' => '',
            'privilege' => '',
            'description' => '',
            'created_at' => '',
            'updated_at' => '',
            'email' => ''
        ]);*/

        DB::table('Member_Position')->insert([
            'position' => 'Executive Director',
            'privilege' => 2,
            'description' => 'Lord of the 12th Can. A resource for everyone on the team and helps make sure everything done is working towards the goals set for the 12th Can.',
            'created_at' => '2019-09-22 23:53:38',
//            'updated_at' => '2019-09-22 23:53:38',
            'email' => '12thcannoreply@gmail.com'
        ]);

        DB::table('Member_Position')->insert([
            'position' => 'Membership Director',
            'privilege' => 2,
            'description' => 'Manages all communications with student volunteers including running the meetings and scheduling volunteer shifts. Also runs the social aspect of the 12th Can by organizing other nonprofits to come speak to the 12th Can and hosting outside social events for 12th Can members.',
            'created_at' => '2019-09-22 23:55:49',
//            'updated_at' => '2019-09-22 23:55:49',
            'email' => '12thcan.membership@gmail.com'
        ]);


    }
}
