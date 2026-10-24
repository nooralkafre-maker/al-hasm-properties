<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void{Schema::create('properties',function(Blueprint $t){
  $t->id();$t->string('reference')->unique();$t->string('slug')->unique();$t->string('title_en');$t->string('title_ar');
  $t->enum('kind',['sale','rent','off_plan'])->index();$t->enum('type',['apartment','villa','townhouse','penthouse','commercial','land'])->index();$t->enum('status',['draft','published','sold','rented','archived'])->default('draft')->index();
  $t->decimal('price',15,2)->index();$t->enum('price_period',['total','monthly','yearly'])->default('total');$t->string('city')->index();$t->string('area')->index();$t->string('address')->nullable();
  $t->decimal('latitude',10,7)->nullable();$t->decimal('longitude',10,7)->nullable();$t->unsignedSmallInteger('bedrooms')->default(0);$t->unsignedSmallInteger('bathrooms')->default(0);$t->unsignedSmallInteger('parking')->default(0);$t->unsignedInteger('area_sqft')->default(0);$t->unsignedSmallInteger('year_built')->nullable();
  $t->longText('description_en')->nullable();$t->longText('description_ar')->nullable();$t->json('amenities')->nullable();$t->string('cover_image',2048)->nullable();$t->json('gallery')->nullable();$t->string('video_url',2048)->nullable();$t->string('virtual_tour_url',2048)->nullable();$t->boolean('featured')->default(false)->index();$t->unsignedInteger('views')->default(0);$t->foreignId('agent_id')->nullable()->constrained('users')->nullOnDelete();$t->timestamps();
  $t->index(['status','kind','city','price']);
 });Schema::table('favorites',fn(Blueprint $t)=>$t->foreign('property_id')->references('id')->on('properties')->cascadeOnDelete());}
 public function down():void{Schema::table('favorites',fn(Blueprint $t)=>$t->dropForeign(['property_id']));Schema::dropIfExists('properties');}
};
