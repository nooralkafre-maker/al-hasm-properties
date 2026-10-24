<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\{Property,User};
class RealEstateSmokeTest extends TestCase {
 use RefreshDatabase;
 public function test_homepage_and_property_search_are_accessible():void{$this->get('/')->assertOk();$this->get('/properties')->assertOk();}
 public function test_admin_requires_authentication():void{$this->get('/admin')->assertRedirect('/login');}
 public function test_public_property_detail_uses_slug_and_hides_drafts():void{
  $p=Property::create(['reference'=>'TEST-X1','slug'=>'testing-villa','title_en'=>'Test Villa','title_ar'=>'فيلا تجريبية','kind'=>'sale','type'=>'villa','status'=>'published','price'=>500000,'city'=>'Sharjah','area'=>'Al Zahia']);
  $this->get('/properties/testing-villa')->assertOk();$p->update(['status'=>'draft']);$this->get('/properties/testing-villa')->assertNotFound();
 }
 public function test_new_inquiry_can_be_submitted():void{
  $this->post('/inquiries',['name'=>'Visitor','phone'=>'+971500000000','purpose'=>'general','message'=>'I would like to speak with your team about a property.'])->assertRedirect();
  $this->assertDatabaseHas('inquiries',['name'=>'Visitor','status'=>'new']);
 }
}
