<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up():void{
 Schema::create('blog_posts',function(Blueprint $t){$t->id();$t->string('slug')->unique();$t->string('title_en');$t->string('title_ar');$t->text('excerpt_en')->nullable();$t->text('excerpt_ar')->nullable();$t->longText('body_en')->nullable();$t->longText('body_ar')->nullable();$t->string('image',2048)->nullable();$t->enum('status',['draft','published'])->default('draft')->index();$t->timestamp('published_at')->nullable();$t->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();$t->timestamps();});
 Schema::create('site_settings',function(Blueprint $t){$t->string('key')->primary();$t->longText('value')->nullable();});
 Schema::create('cms_pages',function(Blueprint $t){$t->id();$t->string('slug')->unique();$t->string('title_en');$t->string('title_ar');$t->longText('body_en')->nullable();$t->longText('body_ar')->nullable();$t->boolean('published')->default(true);$t->timestamps();});
 }
 public function down():void{Schema::dropIfExists('cms_pages');Schema::dropIfExists('site_settings');Schema::dropIfExists('blog_posts');}
};
