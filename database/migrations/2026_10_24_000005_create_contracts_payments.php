<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void{
  Schema::create('contracts',function(Blueprint $t){$t->id();$t->string('contract_no')->unique();$t->foreignId('property_id')->constrained()->cascadeOnDelete();$t->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();$t->string('client_name');$t->string('client_email')->nullable();$t->string('client_phone')->nullable();$t->enum('type',['sale','rent']);$t->decimal('amount',15,2);$t->date('starts_on')->nullable();$t->date('ends_on')->nullable();$t->enum('status',['draft','signed','completed','cancelled'])->default('draft');$t->text('notes')->nullable();$t->timestamps();});
  Schema::create('payments',function(Blueprint $t){$t->id();$t->foreignId('contract_id')->constrained()->cascadeOnDelete();$t->decimal('amount',15,2);$t->date('paid_on');$t->string('category')->default('payment');$t->enum('method',['cash','bank_transfer','cheque','card','other'])->default('bank_transfer');$t->enum('status',['pending','received','refunded'])->default('pending');$t->string('reference')->nullable();$t->text('notes')->nullable();$t->timestamps();});
 }
 public function down():void{Schema::dropIfExists('payments');Schema::dropIfExists('contracts');}
};
