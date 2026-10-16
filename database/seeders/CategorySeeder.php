<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['slug' => 'buttons', 'image' => 'images/cat-buttons.jpg',
             'name_fa' => 'دکمه', 'name_en' => 'Buttons',
             'desc_fa' => 'دکمه‌های شیشه‌ای، چوبی، فلزی و مرواریدی', 'desc_en' => 'Glass, wood, metal & pearl buttons'],
            ['slug' => 'zippers', 'image' => 'images/cat-zippers.jpg',
             'name_fa' => 'زیپ و بست', 'name_en' => 'Zippers & Closures',
             'desc_fa' => 'زیپ مخفی، فلزی و نایلونی', 'desc_en' => 'Invisible, metal & nylon zippers'],
            ['slug' => 'ribbons', 'image' => 'images/cat-ribbons.jpg',
             'name_fa' => 'روبان و نوار', 'name_en' => 'Ribbons & Trims',
             'desc_fa' => 'روبان ساتن، گیپور و نوار تزئینی', 'desc_en' => 'Satin ribbons, lace & decorative trims'],
            ['slug' => 'threads', 'image' => 'images/cat-threads.jpg',
             'name_fa' => 'نخ', 'name_en' => 'Threads',
             'desc_fa' => 'نخ خیاطی، گلدوزی و قرقره رنگی', 'desc_en' => 'Sewing & embroidery threads'],
            ['slug' => 'tools', 'image' => 'images/cat-tools.jpg',
             'name_fa' => 'لوازم خیاطی', 'name_en' => 'Sewing Tools',
             'desc_fa' => 'قیچی، متر، سوزن و ابزار حرفه‌ای', 'desc_en' => 'Scissors, tapes, needles & pro tools'],
            ['slug' => 'decor', 'image' => 'images/cat-decor.jpg',
             'name_fa' => 'تزئینی', 'name_en' => 'Decorative',
             'desc_fa' => 'تور، مروارید، پاپیون و تزئینات', 'desc_en' => 'Tulle, pearls, bows & embellishments'],
            ['slug' => 'fabrics', 'image' => 'images/cat-fabric.jpg',
             'name_fa' => 'پارچه', 'name_en' => 'Fabrics',
             'desc_fa' => 'پارچه ابریشمی، نخی، حریر و چرم', 'desc_en' => 'Silk, cotton, chiffon & faux leather'],
            ['slug' => 'gifts', 'image' => 'images/cat-gift.jpg',
             'name_fa' => 'کادو و بسته‌بندی', 'name_en' => 'Gift & Packaging',
             'desc_fa' => 'جعبه کادو، کاغذ کادو و تزئین هدیه', 'desc_en' => 'Gift boxes, wrapping paper & gift décor'],
        ];

        foreach ($rows as $row) {
            Category::create($row);
        }
    }
}
