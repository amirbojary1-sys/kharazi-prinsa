<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Category::pluck('id', 'slug');
        $sub = Subcategory::pluck('id', 'slug');

        // [category, subcategory, price, stock, featured, image, name_fa, name_en, desc_fa, desc_en]
        $rows = [
            ['buttons', 'btn-glass', 65000, 48, true, 'images/prod-macro-buttons.jpg', 'دکمه شیشه‌ای کلاسیک', 'Classic Glass Buttons', 'بسته ۱۲ عددی دکمه شیشه‌ای تراش‌خورده با رنگ‌های کرم، صورتی و آلویی. مناسب مانتو، کت و لباس مجلسی.', 'Set of 12 faceted glass buttons in cream, rose and plum. Perfect for coats and evening wear.'],
            ['buttons', 'btn-wood', 48000, 60, false, 'images/prod-buttons-wood.jpg', 'دکمه چوبی طبیعی', 'Natural Wood Buttons', 'بسته ۲۰ عددی دکمه چوبی با روکش طبیعی، سایزهای متنوع برای پیراهن و لباس کودک.', 'Set of 20 natural wood buttons in mixed sizes for shirts and kidswear.'],
            ['buttons', 'btn-glass', 72000, 35, true, 'images/prod-buttons-pearl.jpg', 'دکمه مرواریدی خیاطی', 'Pearl Sewing Buttons', 'بسته ۱۵ عددی دکمه مرواریدی براق با پایه فلزی، ایده‌آل برای لباس عروس و مجلسی.', 'Set of 15 glossy pearl buttons with metal shanks — ideal for bridal and formal wear.'],
            ['buttons', 'btn-metal', 89000, 22, false, 'images/cat-buttons.jpg', 'دکمه فلزی برنجی کت', 'Brass Suit Buttons', 'بسته ۶ عددی دکمه فلزی برنجی با طرح کلاسیک، مناسب کت، شلوار و پالتو.', 'Set of 6 classic brass buttons for blazers, trousers and coats.'],
            ['buttons', 'btn-glass', 58000, 42, false, 'images/prod-buttons-pearl.jpg', 'دکمه صدفی لاکچری (۱۰ عددی)', 'Luxury Shell Buttons (10 pcs)', 'دکمه‌های صدفی طبیعی با درخشش مرواریدی، مناسب پیراهن‌های لوکس و لباس‌های خاص.', 'Natural shell buttons with a pearlescent sheen — for luxury shirts and special garments.'],
            ['zippers', 'zip-hidden', 38000, 80, true, 'images/cat-zippers.jpg', 'زیپ مخفی ۲۰ سانتی‌متری', 'Invisible Zipper 20cm', 'زیپ مخفی با دندانه ریز و روان، مناسب دامن و شلوار. در رنگ‌های مشکی، کرم و سرمه‌ای.', 'Smooth invisible zipper for skirts and trousers — black, cream and navy.'],
            ['zippers', 'zip-metal', 62000, 40, true, 'images/prod-zipper-metal.jpg', 'زیپ فلزی ۵۰ سانتی‌متری', 'Metal Zipper 50cm', 'زیپ فلزی ضخیم با کیفیت بالا برای کاپشن، کیف و چرم. سری برنجی مقاوم.', 'Heavy-duty metal zipper for jackets, bags and leather goods.'],
            ['zippers', 'zip-nylon', 45000, 55, false, 'images/cat-zippers.jpg', 'زیپ نایلونی رنگی (۳ عددی)', 'Nylon Zippers (3 pcs)', 'بسته ۳ عددی زیپ نایلونی ۳۰ سانتی‌متری در رنگ‌های شاد و متنوع.', 'Pack of 3 colorful 30cm nylon zippers for everyday sewing.'],
            ['zippers', 'zip-metal', 75000, 34, false, 'images/prod-zipper-metal.jpg', 'زیپ کیف و کفش فلزی', 'Bag & Shoe Metal Zipper', 'زیپ فلزی مخصوص کیف و کفش با سری برنجی مقاوم و حرکت نرم.', 'Metal zipper designed for bags and shoes — sturdy brass pull and smooth glide.'],
            ['ribbons', 'rib-satin', 55000, 70, true, 'images/prod-macro-ribbon.jpg', 'روبان ساتن ۲.۵ سانتی‌متری (۱۰ متر)', 'Satin Ribbon 2.5cm (10m)', 'روبان ساتن براق و نرم در رنگ‌های صورتی، طلایی و سبز. مناسب بسته‌بندی و تزئین.', 'Glossy soft satin ribbon in blush, gold and green — perfect for gift wrapping and décor.'],
            ['ribbons', 'rib-lace', 78000, 30, true, 'images/prod-lace.jpg', 'نوار گیپور تزئینی (۵ متر)', 'Lace Trim (5m)', 'نوار گیپور ظریف با طرح گل، مناسب حاشیه لباس، روتختی و کارهای هنری.', 'Delicate floral lace trim for garment hems, bedding and crafts.'],
            ['ribbons', 'rib-grosgrain', 60000, 45, false, 'images/cat-ribbons.jpg', 'روبان گروسگرین (۱۰ متر)', 'Grosgrain Ribbon (10m)', 'روبان گروسگرین مقاوم با بافت ریز، ایده‌آل برای ساخت پاپیون و تل.', 'Sturdy grosgrain ribbon with fine texture — ideal for bows and headbands.'],
            ['ribbons', 'rib-satin', 42000, 85, false, 'images/cat-ribbons.jpg', 'نوار اریب دوخته‌شده (۲۰ متر)', 'Bias Binding Tape (20m)', 'نوار اریب آماده در رنگ‌های متنوع برای حاشیه‌دوزی تمیز لباس و کاور.', 'Ready-made bias tape in assorted colors for clean hems and covers.'],
            ['threads', 'thr-sew', 135000, 50, true, 'images/prod-macro-thread.jpg', 'نخ پلی‌استر درجه یک (۱۲ رنگ)', 'Polyester Thread Set (12 colors)', 'بسته ۱۲ قرقره نخ پلی‌استر مقاوم در رنگ‌های پرکاربرد، مناسب چرخ خیاطی و دست‌دوزی.', 'Set of 12 strong polyester spools in essential colors — for machine and hand sewing.'],
            ['threads', 'thr-emb', 195000, 28, true, 'images/prod-embroidery.jpg', 'نخ گلدوزی شش‌لا (۲۴ رنگ)', 'Embroidery Floss Set (24 colors)', 'بسته ۲۴ رنگ نخ گلدوزی نرم و براق با کیفیت عالی برای گلدوزی، کراس‌استیچ و ماکارونی‌دوزی.', '24 soft glossy floss skeins for embroidery, cross-stitch and friendship bracelets.'],
            ['threads', 'thr-sew', 42000, 90, false, 'images/cat-threads.jpg', 'نخ خیاطی مشکی حرفه‌ای', 'Pro Black Sewing Thread', 'قرقره بزرگ نخ خیاطی مشکی با استحکام بالا، مناسب مصارف حرفه‌ای.', 'Large spool of high-strength black sewing thread for professional use.'],
            ['threads', 'thr-sew', 68000, 44, false, 'images/prod-macro-thread.jpg', 'نخ کتان طبیعی (بسته ۶ رنگ)', 'Natural Linen Thread (6 colors)', 'نخ کتان طبیعی با بافت زیبا برای دوست‌دوزی، گلدوزی و کارهای هنری روستیک.', 'Natural linen thread with beautiful texture — for hand sewing, embroidery and rustic crafts.'],
            ['tools', 'tool-cut', 420000, 15, true, 'images/prod-scissors.jpg', 'قیچی خیاطی استیل ۲۴ سانتی', 'Tailor Scissors 24cm', 'قیچی خیاطی حرفه‌ای با تیغه استیل ضدزنگ و دسته ارگونومیک. برش دقیق پارچه.', 'Professional tailor scissors with stainless blades and ergonomic handle.'],
            ['tools', 'tool-measure', 35000, 100, false, 'images/cat-tools.jpg', 'متر خیاطی ۱۵۰ سانتی‌متری', 'Measuring Tape 150cm', 'متر خیاطی انعطاف‌پذیر با اعداد خوانا در دو طرف، مناسب خیاطی و اندازه‌گیری بدن.', 'Flexible double-sided measuring tape with clear markings.'],
            ['tools', 'tool-needle', 85000, 65, true, 'images/cat-tools.jpg', 'ست سوزن و سنجاق ته‌گرد', 'Needle & Pin Set', 'مجموعه کامل سوزن دست‌دوزی و سنجاق ته‌گرد شیشه‌ای در جعبه فلزی شیک.', 'Complete hand-needles and glass-head pins set in an elegant tin.'],
            ['tools', 'tool-glue', 110000, 40, false, 'images/cat-tools.jpg', 'چسب پارچه قوی ۵۰ میل', 'Strong Fabric Glue 50ml', 'چسب پارچه شفاف و مقاوم شست‌وشو، مناسب چسباندن تزئینات و اصلاح سریع.', 'Washable clear fabric glue for trims and quick fixes.'],
            ['tools', 'tool-needle', 48000, 70, false, 'images/prod-scissors.jpg', 'کوک‌بازکن استیل حرفه‌ای', 'Pro Seam Ripper', 'کوک‌بازکن حرفه‌ای با دسته ارگونومیک و تیغه بسیار تیز، ابزار ضروری هر خیاط.', 'Professional seam ripper with ergonomic handle and razor-sharp blade — a tailor essential.'],
            ['decor', 'dec-tulle', 95000, 32, true, 'images/prod-tulle.jpg', 'تور تزئینی پهن (۳ متر)', 'Decorative Tulle (3m)', 'تور نرم و لطیف با عرض ۹۰ سانتی‌متر، مناسب تزئین هدیه، سفره و لباس.', 'Soft 90cm-wide tulle for gift wrap, table décor and dresses.'],
            ['decor', 'dec-pearl', 88000, 26, false, 'images/cat-decor.jpg', 'نوار مروارید تزئینی (۲ متر)', 'Pearl Trim (2m)', 'نوار مروارید دوختنی برای حاشیه لباس، کیف و کارهای هنری مجلسی.', 'Sew-on pearl strand for dresses, bags and formal crafts.'],
            ['decor', 'dec-bow', 70000, 38, true, 'images/prod-macro-ribbon.jpg', 'پاپیون آماده ساتن (۶ عددی)', 'Ready Satin Bows (6 pcs)', 'بسته ۶ عددی پاپیون ساتن آماده در رنگ‌های هماهنگ، مناسب تزئین کادو و لباس کودک.', 'Pack of 6 ready satin bows in coordinated colors.'],
            ['decor', 'dec-bow', 52000, 66, false, 'images/cat-decor.jpg', 'پولک و منجوق تزئینی (بسته‌ای)', 'Sequins & Beads Pack', 'بسته رنگارنگ پولک و منجوق برای تزئین لباس، کیف و کارهای هنری مجلسی.', 'Colorful sequins and beads for dresses, bags and glamorous crafts.'],
            ['fabrics', 'fab-silk', 285000, 24, true, 'images/prod-chiffon.jpg', 'پارچه ابریشم ساتن (یارد)', 'Silk Satin Fabric (yard)', 'پارچه ساتن ابریشمی با درخشش لوکس و لمس نرم. مناسب لباس مجلسی، روتختی و دوخت‌های خاص.', 'Luxury silk satin with a rich sheen and soft hand-feel — for evening wear and fine sewing.'],
            ['fabrics', 'fab-cotton', 145000, 40, true, 'images/prod-cotton-fabric.jpg', 'پارچه نخی طرح‌دار (یارد)', 'Printed Cotton Fabric (yard)', 'پارچه نخی صددرصد با طرح‌های شیک و رنگ‌های ثابت. مناسب پیراهن، مانتو و لباس کودک.', '100% cotton with elegant prints and colorfast dyes — shirts, coats and kidswear.'],
            ['fabrics', 'fab-chiffon', 195000, 30, false, 'images/prod-chiffon.jpg', 'پارچه شیفون مجلسی (یارد)', 'Chiffon Fabric (yard)', 'پارچه شیفون سبک و لطیف با افتادگی زیبا، ایده‌آل برای لباس‌های مجلسی و رودوشی.', 'Light, graceful chiffon with beautiful drape — perfect for formal and evening dresses.'],
            ['fabrics', 'fab-leather', 320000, 18, false, 'images/cat-fabric.jpg', 'چرم مصنوعی درجه یک (متر)', 'Premium Faux Leather (meter)', 'چرم مصنوعی با کیفیت بالا، مقاوم و انعطاف‌پذیر برای کیف، کفش و مبلمان.', 'High-quality faux leather — durable and flexible for bags, shoes and upholstery.'],
            ['fabrics', 'fab-silk', 245000, 27, false, 'images/cat-fabric.jpg', 'پارچه مخمل سلطنتی (یارد)', 'Royal Velvet Fabric (yard)', 'مخمل ضخیم و لطیف با بافت غنی، مناسب مبلمان، پرده و لباس‌های زمستانی.', 'Rich, plush velvet — ideal for upholstery, curtains and winter garments.'],
            ['gifts', 'gift-box', 55000, 75, true, 'images/prod-giftbox.jpg', 'جعبه کادو مخملی (۳ سایز)', 'Velvet Gift Box (3 sizes)', 'ست سه‌تایی جعبه کادو با روکش مخمل و روبان طلایی. مناسب هدایای خاص و لوکس.', 'Set of 3 velvet gift boxes with gold ribbon — for special luxury gifts.'],
            ['gifts', 'gift-wrap', 32000, 90, false, 'images/cat-gift.jpg', 'کاغذ کادو کرافت (۱۰ برگ)', 'Kraft Wrapping Paper (10 sheets)', 'کاغذ کادو کرافت با چاپ‌های شیک و جنس مقاوم، مناسب بسته‌بندی هدیه و ارسال.', 'Sturdy kraft wrapping paper with chic prints — perfect for gift wrapping and shipping.'],
            ['gifts', 'gift-bow', 48000, 60, true, 'images/prod-macro-ribbon.jpg', 'روبان کادویی طلایی (۲۵ متر)', 'Gold Gift Ribbon (25m)', 'روبان کادویی طلایی براق برای ساخت پاپیون‌های شیک و تزئین جعبه هدیه.', 'Glossy gold gift ribbon for elegant bows and gift box decoration.'],
            ['gifts', 'gift-box', 42000, 55, false, 'images/cat-gift.jpg', 'پاکت هدیه کاغذی (۱۲ عددی)', 'Paper Gift Bags (12 pcs)', 'بسته ۱۲ عددی پاکت هدیه کاغذی در طرح‌ها و سایزهای مختلف با دسته پیچ‌خورده.', 'Pack of 12 paper gift bags in assorted designs with twisted handles.'],
            ['gifts', 'gift-wrap', 28000, 95, false, 'images/prod-giftbox.jpg', 'برچسب هدیه و اتیکت (۳۰ عددی)', 'Gift Tags & Labels (30 pcs)', 'ست ۳۰ عددی برچسب هدیه شیک با نخ کنفی، مناسب تکمیل بسته‌بندی‌های خاص.', 'Set of 30 chic gift tags with jute string — the finishing touch for special wrapping.'],
        ];

        foreach ($rows as $r) {
            Product::create([
                'category_id'    => $cat[$r[0]],
                'subcategory_id' => $sub[$r[1]],
                'price'          => $r[2],
                'stock'          => $r[3],
                'featured'       => $r[4],
                'image'          => $r[5],
                'name_fa'        => $r[6],
                'name_en'        => $r[7],
                'desc_fa'        => $r[8],
                'desc_en'        => $r[9],
            ]);
        }
    }
}
