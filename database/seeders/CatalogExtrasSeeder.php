<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Review;
use Illuminate\Database\Seeder;

class CatalogExtrasSeeder extends Seeder
{
    public function run(): void
    {
        $all = ['prod-macro-buttons', 'prod-macro-ribbon', 'prod-macro-thread', 'prod-buttons-wood',
            'prod-buttons-pearl', 'prod-zipper-metal', 'prod-lace', 'prod-embroidery', 'prod-scissors',
            'prod-tulle', 'prod-giftbox', 'prod-cotton-fabric', 'prod-chiffon', 'prod-sequins', 'prod-velvet-fabric'];

        // ---- galleries: give the first 12 products extra images ----
        Product::orderBy('id')->take(12)->get()->each(function ($p, $i) use ($all) {
            $extras = array_slice(array_merge(array_slice($all, $i % 5), array_slice($all, 0, $i % 5)), 0, 3);
            foreach (array_unique($extras) as $j => $img) {
                if ($img === basename($p->image, '.jpg')) {
                    continue;
                }
                ProductImage::firstOrCreate(
                    ['product_id' => $p->id, 'image' => "images/{$img}.jpg"],
                    ['sort' => $j]
                );
            }
        });

        // ---- variants ----
        $variants = [
            // product_id => [ [fa, en, delta, stock], ... ]
            1 => [['قرمز', 'Red', 0, 40], ['آبی', 'Blue', 0, 35], ['مشکی', 'Black', 2000, 28], ['کرم', 'Cream', 0, 50]],
            2 => [['طلایی', 'Gold', 5000, 22], ['نقره‌ای', 'Silver', 0, 30], ['رزگلد', 'Rose Gold', 5000, 14]],
            3 => [['سفید', 'White', 0, 60], ['مشکی', 'Black', 0, 45], ['سرمه‌ای', 'Navy', 0, 38]],
            5 => [['قطر ۱۵ میل', '15mm', 0, 90], ['قطر ۲۰ میل', '20mm', 8000, 70], ['قطر ۲۵ میل', '25mm', 15000, 55]],
            7 => [['یک‌حلقه‌ای', 'Single coil', 0, 25], ['سه‌حلقه‌ای', 'Triple coil', 25000, 18]],
            9 => [['قیچی کوچک', 'Small scissors', 0, 33], ['قیچی بزرگ', 'Large scissors', 35000, 21]],
        ];
        foreach ($variants as $pid => $rows) {
            if (!Product::find($pid)) {
                continue;
            }
            foreach ($rows as $i => [$fa, $en, $delta, $stock]) {
                ProductVariant::firstOrCreate(
                    ['product_id' => $pid, 'name_fa' => $fa],
                    ['name_en' => $en, 'price_delta' => $delta, 'stock' => $stock, 'sort' => $i]
                );
            }
        }

        // ---- reviews ----
        $reviews = [
            [1, 'مریم احمدی', 5, 'کیفیت دکمه‌ها عالیه، رنگ‌ها دقیقاً مثل عکسه. برای مانتو استفاده کردم.'],
            [1, 'زهرا کریمی', 4, 'بسته‌بندی تمیز بود و زود رسید. فقط کاش تعدادش بیشتر بود.'],
            [2, 'سارا موسوی', 5, 'دکمه مرواریدی واقعاً شیکه، روی پیراهن مجلسی فوق‌العاده شد.'],
            [2, 'نگار رضایی', 5, 'برای لباس عروسی خواهرم گرفتم، همه پرسیدن از کجا خریدیم!'],
            [3, 'امیر حسینی', 4, 'زیپ محکمه و روان باز و بسته میشه. راضی بودم.'],
            [3, 'رضا صادقی', 5, 'بهترین زیپی که تا حالا خریدم. دوخت روش راحته.'],
            [5, 'فاطمه نجفی', 5, 'نخ بسیار باکیفیت، پارچه نخی رو عالی می‌دوزه.'],
            [5, 'مینا شریفی', 4, 'ضخامت خوبی داره، برای گلدوزی مناسبه.'],
            [6, 'علی رحیمی', 5, 'قیچی خیلی تیز و برنده‌ست، دسته‌ش هم راحته.'],
            [7, 'الهام محمدی', 5, 'گیپور ظریف و خوشگله، دقیقاً همون چیزی که می‌خواستم.'],
            [8, 'مهسا اکبری', 4, 'طرح گلدوزی قشنگه، فقط رنگش کمی با عکس فرق داشت.'],
            [9, 'ترانه کاظمی', 5, 'تور نرم و لطیفه، برای تزئین جشن عالی بود.'],
            [10, 'نازنین حیدری', 5, 'جعبه کادو خیلی شیک و محکمه، ارزش خرید داره.'],
            [11, 'پریسا امینی', 4, 'پارچه نخی لطیفه، برای تابستان عالیه.'],
            [12, 'شیدا نادری', 5, 'شیفون مجلسی با کیفیت، چروک نمیشه.'],
            [1, 'کاربر مهمان', 3, 'خوب بود ولی انتظار بسته بزرگ‌تری داشتم.'],
            [4, 'آرزو یوسفی', 5, 'دکمه چوبی طبیعی و خاص، برای کارهای هنری عالیه.'],
            [4, 'محدثه قاسمی', 4, 'رنگ طبیعی چوب قشنگه، سایزش هم مناسب بود.'],
            [6, 'بیتا زمانی', 5, 'برای کیف دستی استفاده کردم، نتیجه حرفه‌ای شد.'],
            [7, 'لیلا اکرمی', 4, 'قیمت نسبت به کیفیت مناسبه.'],
            [8, 'سحر رمضانی', 5, 'گلدوزی روی لباس بچه‌گانه فوق‌العاده شد.'],
            [9, 'نرگس صبوری', 5, 'تزئین میز جشن با این تور همه رو سورپرایز کرد.'],
            [2, 'مریم احمدی', 4, 'بار دوم هم خریدم، کیفیت ثابته.'],
            [11, 'الناز جعفری', 5, 'پارچه دقیقاً مثل توضیحات، خرید مطمئنی بود.'],
            [12, 'ستاره عبدی', 4, 'برای پیراهن مجلسی گرفتم، خوب بود.'],
        ];
        foreach ($reviews as [$pid, $name, $rating, $comment]) {
            if (!Product::find($pid)) {
                continue;
            }
            Review::firstOrCreate(
                ['product_id' => $pid, 'author_name' => $name, 'comment' => $comment],
                ['rating' => $rating, 'status' => 'approved', 'user_id' => null]
            );
        }

        $this->command?->info('Catalog extras seeded: images=' . ProductImage::count()
            . ' variants=' . ProductVariant::count() . ' reviews=' . Review::count());
    }
}
