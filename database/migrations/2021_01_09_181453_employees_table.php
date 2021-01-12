<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('father_name');
            $table->string('grand_father_name');
            $table->integer('center_id');
            $table->date('dob');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('contact_number');
            $table->string('email')->nullable();
            $table->string('current_address_line_1');
            $table->string('current_address_district');
            $table->string('current_address_province');
            $table->string('permanent_address_line_1');
            $table->string('permanent_address_district');
            $table->string('permanent_address_province');
            $table->string('education_level')->nullable();
            $table->string('education_field')->nullable();
            $table->string('education_institution')->nullable();
            $table->string('id_type',1)->default('P');
            $table->text('id_details');
            $table->string('section');
            $table->string('directorate');
            $table->string('position_code');
            $table->string('position_type');
            $table->string('post_title');
            $table->string('project_name');
            $table->string('monthly_salary')->nullable();
            $table->integer('status')->default(0);
            $table->string('contract_start_date')->nullable();
            $table->string('contract_end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
