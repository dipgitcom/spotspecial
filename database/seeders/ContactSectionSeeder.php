<?php

namespace Database\Seeders\ContactSectionSeeder;

use App\Models\ContactSection;
use App\Models\ContactField;
use App\Models\ContactArea;
use App\Models\ContactCard;

ContactSection::create([
    'title'=>'Ready for a non-binding offer?',
    'subtitle'=>'Describe your space, number of spots and possibly images. We respond quickly.'
]);

ContactField::insert([
    ['key'=>'name','label'=>'Name','placeholder'=>'Name','type'=>'text','required'=>1,'order'=>1],
    ['key'=>'phone','label'=>'Telephone','placeholder'=>'Telephone','type'=>'text','required'=>1,'order'=>2],
    ['key'=>'email','label'=>'Email','placeholder'=>'E-mail','type'=>'email','required'=>1,'order'=>3],
    ['key'=>'area','label'=>'Area in Copenhagen','placeholder'=>'Area in Copenhagen','type'=>'select','required'=>1,'order'=>4],
    ['key'=>'spots','label'=>'Number of spots (circa)','placeholder'=>'Number of spots (circa)','type'=>'number','required'=>0,'order'=>5],
    ['key'=>'description','label'=>'Brief description of the task','placeholder'=>'Brief description of the task','type'=>'textarea','required'=>0,'order'=>6],
    ['key'=>'button','label'=>'Get price','placeholder'=>null,'type'=>'button','required'=>0,'order'=>7]
]);

ContactArea::insert([
    ['value'=>'Østerbro','order'=>1],['value'=>'Nørrebro','order'=>2],['value'=>'Vesterbro','order'=>3],
    ['value'=>'Amager','order'=>4],['value'=>'Valby','order'=>5],['value'=>'Frederiksberg','order'=>6],
    ['value'=>'Hellerup','order'=>7],['value'=>'Vanløse','order'=>8]
]);

ContactCard::create([
    'title'=>'Contact',
    'phone'=>'+45 71 99 24 70',
    'email'=>'tilbud@spotspecialisten.dk',
    'address'=>'København',
    'hours'=>'Monday – Friday 07 – 18',
    'pill_text'=>'CVR and documentation are provided upon ordering',
    'disclaimer'=>'Upon submission, you agree that we must contact you. offer.'
]);

