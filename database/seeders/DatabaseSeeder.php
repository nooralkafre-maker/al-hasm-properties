<?php
namespace Database\Seeders;
use App\Models\{Property,BlogPost,CmsPage,SiteSetting};
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder {
 public function run():void{
  $settings=[
   'company_name'=>'AL HASM Properties','tagline_en'=>'Discover distinguished properties, inspired living and exciting investment opportunities across the UAE.',
   'tagline_ar'=>'اكتشف عقارات مميزة ومساحات ملهمة وفرصاً استثمارية في الإمارات.',
   'phone'=>'','whatsapp'=>'','email'=>'','address'=>'Sharjah, UAE',
   'meta_description_en'=>'Discover premium real estate for sale and rent in Sharjah, Dubai and across the UAE with AL HASM Properties.',
   'meta_description_ar'=>'اكتشف عقارات للبيع والإيجار في الشارقة ودبي والإمارات مع الحسم العقارية.',
  ];foreach($settings as $k=>$v)SiteSetting::updateOrCreate(['key'=>$k],['value'=>$v]);
  $rows=[
   ['Modern Luxury Villa in Al Zahia','فيلا عصرية فاخرة في الزاهية','sale','villa','Sharjah','Al Zahia',5800000,5,6,6200,'villa-a.jpg'],
   ['Waterfront Apartment in Dubai Marina','شقة على الواجهة البحرية في دبي مارينا','rent','apartment','Dubai','Dubai Marina',190000,3,4,2100,'apartment.jpg'],
   ['Contemporary Villa with Private Pool','فيلا حديثة مع مسبح خاص','sale','villa','Dubai','Dubai Hills',8750000,5,6,5200,'villa-b.jpg'],
   ['Bright Family Apartment in Al Majaz','شقة عائلية مشرقة في المجاز','rent','apartment','Sharjah','Al Majaz',85000,2,2,1450,'skyline-clean.jpg'],
   ['Stylish Townhouse at Aljada','تاون هاوس أنيق في الجادة','sale','townhouse','Sharjah','Aljada',2400000,3,3,2800,'villa-c.jpg'],
   ['Exclusive Penthouse with Marina Views','بنتهاوس حصري بإطلالة على المارينا','sale','penthouse','Dubai','Dubai Marina',12300000,4,5,4500,'apartment.jpg'],
   ['Brand New Residence in Sharjah','وحدة سكنية جديدة في الشارقة','off_plan','apartment','Sharjah','Maryam Island',1250000,2,2,1320,'villa-d.jpg'],
   ['Elegant Family Villa in Tilal Al Ghaf','فيلا عائلية أنيقة في تلال الغاف','sale','villa','Dubai','Tilal Al Ghaf',6350000,4,5,4450,'villa-b.jpg'],
   ['Modern City Apartment in Business Bay','شقة حديثة في الخليج التجاري','rent','apartment','Dubai','Business Bay',145000,2,2,1180,'skyline-clean.jpg'],
   ['Commercial Office near Corniche','مكتب تجاري قرب الكورنيش','rent','commercial','Sharjah','Al Majaz',220000,0,2,2600,'apartment.jpg'],
   ['Premium Townhouse in Arabian Ranches','تاون هاوس مميز في المرابع العربية','sale','townhouse','Dubai','Arabian Ranches',4250000,4,4,3300,'villa-c.jpg'],
   ['New Project at Al Khan Waterfront','مشروع جديد على الواجهة البحرية بالخـان','off_plan','apartment','Sharjah','Al Khan',990000,1,2,1010,'skyline-clean.jpg'],
  ];
  foreach($rows as $n=>$r){[$en,$ar,$kind,$type,$city,$area,$price,$beds,$baths,$sqft,$image]=$r;
   Property::updateOrCreate(['reference'=>'DEMO-'.str_pad($n+1,4,'0',STR_PAD_LEFT)],['slug'=>'demo-property-'.($n+1),'title_en'=>$en,'title_ar'=>$ar,'kind'=>$kind,'type'=>$type,'status'=>'published','price'=>$price,'price_period'=>$kind==='rent'?'yearly':'total','city'=>$city,'area'=>$area,'address'=>$area.', '.$city.', United Arab Emirates','bedrooms'=>$beds,'bathrooms'=>$baths,'parking'=>2,'area_sqft'=>$sqft,'year_built'=>2024,'featured'=>$n<6,'cover_image'=>'https://images.unsplash.com/'.($kind==='rent'?'photo-1600607687939-ce8a6c25118c':(['photo-1600596542815-ffad4c1539a9','photo-1600585154340-be6161a56a0c','photo-1600047509807-ba8f99d2cdde'][$n%3])).'?auto=format&fit=crop&w=1100&q=85',
   'gallery'=>['https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?auto=format&fit=crop&w=900&q=80','https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=900&q=80'],
   'amenities'=>['Covered Parking','Balcony','Security','Modern Finishing','Close to Amenities','Spacious Living'],
   'description_en'=>'Illustrative demo listing only — not a real property offer. Experience beautifully designed spaces, premium finishes, inviting living areas and excellent access to local services. Replace with verified property photographs, complete documentation and accurate details before launching publicly.',
   'description_ar'=>'إعلان تجريبي توضيحي فقط وليس عرضاً لعقار حقيقي. تصميم عصري ومساحات واسعة وتشطيبات راقية وقرب من الخدمات. يرجى استبداله بمعلومات وصور ووثائق عقارات حقيقية وموثقة قبل نشر الموقع.',
   ]);
  }
  $posts=[
   ['A Guide to Buying Property in the UAE','دليل شراء العقارات في الإمارات','Understand essential considerations when buying a home.','تعرّف على أهم الأمور عند شراء منزل.','This sample article introduces general topics to discuss with a licensed professional: budget, due diligence, property paperwork and ongoing costs. Verify local requirements before purchasing.','مقال تجريبي يقدم نقاطاً عامة حول الميزانية والتحقق من المستندات والتكاليف. يجب مراجعة المتطلبات المحلية مع جهة مختصة قبل الشراء.'],
   ['Choosing the Right Neighborhood','كيف تختار الحي المناسب','Consider lifestyle, commute, amenities and long-term plans.','فكر في نمط الحياة والتنقل والخدمات والخطط المستقبلية.','The best neighborhood is the one that matches daily life, your budget and your goals. Compare access, quality of buildings, services and local market conditions.','الحي المناسب هو الذي يلائم حياتك اليومية وميزانيتك وأهدافك. قارن جودة المباني والمواصلات والخدمات وظروف السوق المحلي.'],
   ['Renting vs Buying: Key Questions','الإيجار أم الشراء: أهم الأسئلة','Explore the decisions that influence renting and buying.','تعرّف على العوامل المؤثرة في قرار الإيجار والشراء.','Compare expected length of stay, financial flexibility, purchase costs, maintenance commitments and market uncertainty before making a property decision.','وازن بين مدة الإقامة والمرونة المالية وتكاليف الشراء والصيانة وتقلبات السوق قبل اتخاذ القرار العقاري.'],
  ];foreach($posts as $i=>$p){BlogPost::updateOrCreate(['slug'=>'sample-market-insight-'.($i+1)],['title_en'=>$p[0],'title_ar'=>$p[1],'excerpt_en'=>$p[2],'excerpt_ar'=>$p[3],'body_en'=>$p[4],'body_ar'=>$p[5],'status'=>'published','published_at'=>now()->subDays($i*7),'image'=>'https://images.unsplash.com/'.(['photo-1600596542815-ffad4c1539a9','photo-1600607687939-ce8a6c25118c','photo-1600585154340-be6161a56a0c'][$i]).'?auto=format&fit=crop&w=1000&q=80']);}
  $pages=[
    ['about','About AL HASM Properties','عن الحسم العقارية','AL HASM Properties is a modern real-estate website demonstration. Our vision is to help people browse quality homes and rental opportunities through a simple, transparent digital experience. Replace this sample company profile with verified registration, licensing, team, and company information before launching.','الحسم العقارية نموذج عرض تجريبي لمنصة عقارية حديثة. رؤيتنا مساعدة العملاء في البحث عن العقارات وفرص الإيجار بطريقة واضحة ومريحة. يجب استبدال هذا النص ببيانات الشركة وترخيصها وفريقها المعتمد قبل الإطلاق.'],
    ['services','Our Real Estate Services','خدماتنا العقارية','Property sales and renting inquiries, agent consultations, viewing appointments and market information. All offerings on this demo website are examples until the company activates the relevant services.','الاستفسارات عن البيع والإيجار والاستشارات العقارية وطلبات المعاينة والمعلومات السوقية. جميع الخدمات الواردة في هذه النسخة توضيحية حتى اعتمادها من الشركة.'],
    ['privacy','Privacy Policy','سياسة الخصوصية','Sample privacy text, not final legal advice. The platform processes names, emails, phone numbers and messages when visitors submit inquiries or viewing requests. The business must finalize retention periods, privacy contact details, legal bases and any third-party integrations before production.','نص خصوصية تجريبي وليس استشارة قانونية. تعالج المنصة بيانات الاسم والهاتف والبريد والرسائل في استفسارات العملاء وطلبات المعاينة. يجب اعتماد سياسة نهائية توضح مدة الاحتفاظ بالبيانات وطرق التواصل والأطراف الأخرى قبل الإطلاق.'],
    ['terms','Terms & Conditions','الشروط والأحكام','Sample terms only. Listings, images and prices in the demo are illustrative, not binding offers. The company should obtain review from appropriate legal advisors and publish its actual terms of service before enabling public use.','هذه شروط تجريبية فقط. الإعلانات والصور والأسعار التجريبية ليست عروضاً ملزمة. يجب اعتماد شروط الاستخدام الحقيقية بعد مراجعتها قانونياً وقبل فتح الموقع للاستخدام العام.'],
  ];foreach($pages as [$slug,$en,$ar,$bodyEn,$bodyAr])CmsPage::updateOrCreate(['slug'=>$slug],['title_en'=>$en,'title_ar'=>$ar,'body_en'=>$bodyEn,'body_ar'=>$bodyAr,'published'=>true]);
 }
}
