<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportEmployeesView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement($this->dropView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function createView(): string
    {

        return 
        'CREATE VIEW employee_exports AS SELECT
            employees.id_number,
            employees.name,
            employees.surname,
            employees.father_name,
            employees.grand_father_name,
            employees.dob,
            employees.gender,
            employees.marital_status,
            employees.id_details,
            employees.contract_start_date,
            employees.contract_end_date,
            employees.contact_number,
            centers.id as center_id,
            centers.name as center_name,
            centers.province as center_province,
            centers.country as center_country,
            posts.id as post_id,
            posts.post_code,
            posts.salary,
            posts.type,
            posts.ddg,
            posts.has_employee,
            posts.project
            
        FROM
            employees
            JOIN posts ON posts.id = employees.post_id
            JOIN centers ON centers.id = employees.center_id
        ';
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function dropView(): string
    {
        return 'DROP VIEW IF EXISTS employee_exports';
    }
}
