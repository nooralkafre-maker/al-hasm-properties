<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void {
  Schema::create('users',function(Blueprint $t){$t->id();$t->string('name');$t->string('email')->unique();$t->timestamp('email_verified_at')->nullable();$t->string('phone')->nullable();$t->string('password');$t->enum('role',['admin','agent','client'])->default('client');$t->boolean('active')->default(true);$t->text('bio')->nullable();$t->string('photo')->nullable();$t->rememberToken();$t->timestamps();});
  Schema::create('password_reset_tokens',function(Blueprint $t){$t->string('email')->primary();$t->string('token');$t->timestamp('created_at')->nullable();});
  Schema::create('favorites',function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained()->cascadeOnDelete();$t->unsignedBigInteger('property_id');$t->timestamps();$t->unique(['user_id','property_id']);});
 }
 public function down():void{Schema::dropIfExists('favorites');Schema::dropIfExists('password_reset_tokens');Schema::dropIfExists('users');}
};
