<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void{
  Schema::create('inquiries',function(Blueprint $t){$t->id();$t->foreignId('property_id')->nullable()->constrained()->nullOnDelete();$t->string('name');$t->string('email')->nullable();$t->string('phone');$t->string('purpose')->default('general');$t->text('message');$t->enum('status',['new','contacted','viewing','negotiating','closed'])->default('new')->index();$t->string('source')->default('website');$t->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();$t->text('notes')->nullable();$t->timestamps();});
  Schema::create('appointments',function(Blueprint $t){$t->id();$t->foreignId('property_id')->nullable()->constrained()->nullOnDelete();$t->string('name');$t->string('email')->nullable();$t->string('phone');$t->dateTime('scheduled_at');$t->enum('status',['pending','confirmed','completed','cancelled'])->default('pending')->index();$t->text('notes')->nullable();$t->timestamps();});
  Schema::create('subscribers',function(Blueprint $t){$t->id();$t->string('email')->unique();$t->timestamps();});
 }
 public function down():void{Schema::dropIfExists('subscribers');Schema::dropIfExists('appointments');Schema::dropIfExists('inquiries');}
};
