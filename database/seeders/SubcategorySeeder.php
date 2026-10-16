<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['buttons', 'btn-glass', 'شیشه‌ای و مرواریدی', 'Glass & Pearl'],
            ['buttons', 'btn-wood', 'چوبی', 'Wooden'],
            ['buttons', 'btn-metal', 'فلزی', 'Metal'],
            ['zippers', 'zip-hidden', 'زیپ مخفی', 'Invisible'],
            ['zippers', 'zip-metal', 'زیپ فلزی', 'Metal'],
            ['zippers', 'zip-nylon', 'زیپ نایلونی', 'Nylon'],
            ['ribbons', 'rib-satin', 'ساتن', 'Satin'],
            ['ribbons', 'rib-lace', 'گیپور و تور', 'Lace & Tulle'],
            ['ribbons', 'rib-grosgrain', 'گروسگرین', 'Grosgrain'],
            ['threads', 'thr-sew', 'نخ خیاطی', 'Sewing'],
            ['threads', 'thr-emb', 'نخ گلدوزی', 'Embroidery'],
            ['tools', 'tool-cut', 'برش و قیچی', 'Cutting'],
            ['tools', 'tool-measure', 'اندازه‌گیری', 'Measuring'],
            ['tools', 'tool-needle', 'سوزن و سنجاق', 'Needles & Pins'],
            ['tools', 'tool-glue', 'چسب', 'Glue'],
            ['decor', 'dec-tulle', 'تور', 'Tulle'],
            ['decor', 'dec-pearl', 'مروارید', 'Pearls'],
            ['decor', 'dec-bow', 'پاپیون', 'Bows'],
            ['fabrics', 'fab-silk', 'ابریشم و ساتن', 'Silk & Satin'],
            ['fabrics', 'fab-cotton', 'نخی و کتان', 'Cotton & Linen'],
            ['fabrics', 'fab-chiffon', 'شیفون و حریر', 'Chiffon & Georgette'],
            ['fabrics', 'fab-leather', 'چرم مصنوعی', 'Faux Leather'],
            ['gifts', 'gift-box', 'جعبه کادو', 'Gift Boxes'],
            ['gifts', 'gift-wrap', 'کاغذ و پاکت', 'Wrapping & Envelopes'],
            ['gifts', 'gift-bow', 'ربان و تزئین هدیه', 'Bows & Gift Décor'],
        ];

        $catIds = Category::pluck('id', 'slug');
        foreach ($rows as $r) {
            Subcategory::create([
                'category_id' => $catIds[$r[0]],
                'slug'        => $r[1],
                'name_fa'     => $r[2],
                'name_en'     => $r[3],
            ]);
        }
    }
}
