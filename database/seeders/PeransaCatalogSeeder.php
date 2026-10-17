<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Review;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

/**
 * Real catalog migrated from kharaziperansa.ir (39 products, 10 categories).
 */
class PeransaCatalogSeeder extends Seeder
{
    public function run(): void
    {
        // reset catalog
        Review::query()->delete();
        ProductImage::query()->delete();
        \App\Models\ProductVariant::query()->delete();
        Product::query()->delete();
        Subcategory::query()->delete();
        Category::query()->delete();

        /* ---------------- categories ---------------- */
        $cats = [];
        $cats['fabric'] = Category::create(['slug' => 'fabric', 'name_fa' => 'پارچه', 'name_en' => 'Fabric', 'desc_fa' => 'انواع پارچه بافت، حریر، ساتن، کتان، مخمل و نخی', 'desc_en' => 'Woven, chiffon, satin, linen, velvet & cotton fabrics', 'image' => 'images/cat-peransa-fabric.jpg']);
        $cats['sewing-machine'] = Category::create(['slug' => 'sewing-machine', 'name_fa' => 'چرخ خیاطی و قطعات', 'name_en' => 'Sewing Machines & Parts', 'desc_fa' => 'چرخ خیاطی خانگی و صنعتی، قطعات و لوازم جانبی', 'desc_en' => 'Home & industrial sewing machines, parts & accessories', 'image' => 'images/cat-peransa-sewing-machine.jpg']);
        $cats['buttons-zippers'] = Category::create(['slug' => 'buttons-zippers', 'name_fa' => 'دکمه، زیپ و یراق', 'name_en' => 'Buttons, Zippers & Hardware', 'desc_fa' => 'دکمه، زیپ، قزن، کش، برچسب و یراق کیف', 'desc_en' => 'Buttons, zippers, clasps, elastic, labels & bag hardware', 'image' => 'images/cat-peransa-buttons-zippers.jpg']);
        $cats['ribbon-lace-tulle'] = Category::create(['slug' => 'ribbon-lace-tulle', 'name_fa' => 'روبان، دانتل و تور', 'name_en' => 'Ribbons, Lace & Tulle', 'desc_fa' => 'روبان ساتن و مخمل، دانتل، گیپور، تور و نوار اریب', 'desc_en' => 'Satin & velvet ribbons, guipure lace, tulle & bias tape', 'image' => 'images/cat-peransa-ribbon-lace-tulle.jpg']);
        $cats['scissors-and-tools'] = Category::create(['slug' => 'scissors-and-tools', 'name_fa' => 'قیچی و ابزار خیاطی', 'name_en' => 'Scissors & Sewing Tools', 'desc_fa' => 'قیچی خیاطی و گلدوزی، درفش، رولت، متر و ابزار', 'desc_en' => 'Tailor & embroidery scissors, seam rippers, marking & measuring tools', 'image' => 'images/cat-peransa-scissors-and-tools.jpg']);
        $cats['yarn-and-knitting'] = Category::create(['slug' => 'yarn-and-knitting', 'name_fa' => 'کاموا و بافتنی', 'name_en' => 'Yarn & Knitting', 'desc_fa' => 'کاموا، میل بافتنی، قلاب بافی و لوازم بافت', 'desc_en' => 'Yarn, knitting needles, crochet hooks & accessories', 'image' => 'images/cat-peransa-yarn-and-knitting.jpg']);
        $cats['storage-and-bags'] = Category::create(['slug' => 'storage-and-bags', 'name_fa' => 'کیف و سازماندهی لوازم', 'name_en' => 'Storage & Bags', 'desc_fa' => 'کیف خیاطی، جعبه، سبد و سازماندهنده لوازم', 'desc_en' => 'Sewing bags, boxes, baskets & organizers', 'image' => 'images/cat-peransa-storage-and-bags.jpg']);
        $cats['embroidery'] = Category::create(['slug' => 'embroidery', 'name_fa' => 'گلدوزی و شماره‌دوزی', 'name_en' => 'Embroidery & Cross-stitch', 'desc_fa' => 'نخ و حلقه گلدوزی، پارچه آیدا و کیت گلدوزی', 'desc_en' => 'Embroidery floss & hoops, Aida cloth & embroidery kits', 'image' => 'images/cat-peransa-embroidery.jpg']);
        $cats['beads-sequins'] = Category::create(['slug' => 'beads-sequins', 'name_fa' => 'منجوق، پولک و نگین', 'name_en' => 'Beads, Sequins & Rhinestones', 'desc_fa' => 'منجوق، پولک، مروارید، سنگ تزئینی و نگین چسبی', 'desc_en' => 'Beads, sequins, pearls, decorative stones & rhinestones', 'image' => 'images/cat-peransa-beads-sequins.jpg']);
        $cats['thread-and-needle'] = Category::create(['slug' => 'thread-and-needle', 'name_fa' => 'نخ و سوزن', 'name_en' => 'Thread & Needles', 'desc_fa' => 'نخ دوخت، سوزن دستی و چرخ، ماسموره و لوازم رفوگری', 'desc_en' => 'Sewing threads, hand & machine needles, bobbins & darning supplies', 'image' => 'images/cat-peransa-thread-and-needle.jpg']);

        /* ---------------- subcategories ---------------- */
        $subs = [];
        $subs['knit-fabric'] = Subcategory::create(['category_id' => $cats['fabric']->id, 'slug' => 'knit-fabric', 'name_fa' => 'پارچه بافت', 'name_en' => 'Knit Fabric']);
        $subs['chiffon-fabric'] = Subcategory::create(['category_id' => $cats['fabric']->id, 'slug' => 'chiffon-fabric', 'name_fa' => 'پارچه حریر', 'name_en' => 'Chiffon Fabric']);
        $subs['satin-fabric'] = Subcategory::create(['category_id' => $cats['fabric']->id, 'slug' => 'satin-fabric', 'name_fa' => 'پارچه ساتن', 'name_en' => 'Satin Fabric']);
        $subs['linen-fabric'] = Subcategory::create(['category_id' => $cats['fabric']->id, 'slug' => 'linen-fabric', 'name_fa' => 'پارچه کتان', 'name_en' => 'Linen Fabric']);
        $subs['velvet-fabric'] = Subcategory::create(['category_id' => $cats['fabric']->id, 'slug' => 'velvet-fabric', 'name_fa' => 'پارچه مخمل', 'name_en' => 'Velvet Fabric']);
        $subs['cotton-fabric'] = Subcategory::create(['category_id' => $cats['fabric']->id, 'slug' => 'cotton-fabric', 'name_fa' => 'پارچه نخی', 'name_en' => 'Cotton Fabric']);
        $subs['home-sewing-machine'] = Subcategory::create(['category_id' => $cats['sewing-machine']->id, 'slug' => 'home-sewing-machine', 'name_fa' => 'چرخ خیاطی خانگی', 'name_en' => 'Home Sewing Machines']);
        $subs['industrial-sewing-machine'] = Subcategory::create(['category_id' => $cats['sewing-machine']->id, 'slug' => 'industrial-sewing-machine', 'name_fa' => 'چرخ خیاطی صنعتی', 'name_en' => 'Industrial Sewing Machines']);
        $subs['oil-and-care'] = Subcategory::create(['category_id' => $cats['sewing-machine']->id, 'slug' => 'oil-and-care', 'name_fa' => 'روغن و نگهداری', 'name_en' => 'Oil & Care']);
        $subs['machine-parts'] = Subcategory::create(['category_id' => $cats['sewing-machine']->id, 'slug' => 'machine-parts', 'name_fa' => 'قطعات چرخ', 'name_en' => 'Machine Parts']);
        $subs['machine-accessories'] = Subcategory::create(['category_id' => $cats['sewing-machine']->id, 'slug' => 'machine-accessories', 'name_fa' => 'لوازم جانبی چرخ', 'name_en' => 'Machine Accessories']);
        $subs['machine-table'] = Subcategory::create(['category_id' => $cats['sewing-machine']->id, 'slug' => 'machine-table', 'name_fa' => 'میز و پایه چرخ', 'name_en' => 'Machine Tables & Stands']);
        $subs['labels'] = Subcategory::create(['category_id' => $cats['buttons-zippers']->id, 'slug' => 'labels', 'name_fa' => 'برچسب و لیبل', 'name_en' => 'Labels']);
        $subs['buttons'] = Subcategory::create(['category_id' => $cats['buttons-zippers']->id, 'slug' => 'buttons', 'name_fa' => 'دکمه', 'name_en' => 'Buttons']);
        $subs['zippers'] = Subcategory::create(['category_id' => $cats['buttons-zippers']->id, 'slug' => 'zippers', 'name_fa' => 'زیپ', 'name_en' => 'Zippers']);
        $subs['clasps'] = Subcategory::create(['category_id' => $cats['buttons-zippers']->id, 'slug' => 'clasps', 'name_fa' => 'قزن و بست', 'name_en' => 'Clasps & Fasteners']);
        $subs['elastic-band'] = Subcategory::create(['category_id' => $cats['buttons-zippers']->id, 'slug' => 'elastic-band', 'name_fa' => 'کش و بند', 'name_en' => 'Elastic Bands']);
        $subs['bag-hardware'] = Subcategory::create(['category_id' => $cats['buttons-zippers']->id, 'slug' => 'bag-hardware', 'name_fa' => 'یراق کیف', 'name_en' => 'Bag Hardware']);
        $subs['tulle'] = Subcategory::create(['category_id' => $cats['ribbon-lace-tulle']->id, 'slug' => 'tulle', 'name_fa' => 'تور', 'name_en' => 'Tulle']);
        $subs['lace-guipure'] = Subcategory::create(['category_id' => $cats['ribbon-lace-tulle']->id, 'slug' => 'lace-guipure', 'name_fa' => 'دانتل و گیپور', 'name_en' => 'Lace & Guipure']);
        $subs['printed-ribbon'] = Subcategory::create(['category_id' => $cats['ribbon-lace-tulle']->id, 'slug' => 'printed-ribbon', 'name_fa' => 'روبان چاپی', 'name_en' => 'Printed Ribbons']);
        $subs['satin-ribbon'] = Subcategory::create(['category_id' => $cats['ribbon-lace-tulle']->id, 'slug' => 'satin-ribbon', 'name_fa' => 'روبان ساتن', 'name_en' => 'Satin Ribbons']);
        $subs['velvet-ribbon'] = Subcategory::create(['category_id' => $cats['ribbon-lace-tulle']->id, 'slug' => 'velvet-ribbon', 'name_fa' => 'روبان مخمل', 'name_en' => 'Velvet Ribbons']);
        $subs['bias-tape'] = Subcategory::create(['category_id' => $cats['ribbon-lace-tulle']->id, 'slug' => 'bias-tape', 'name_fa' => 'نوار اریب و کش', 'name_en' => 'Bias Tape & Elastic']);
        $subs['machine-tools'] = Subcategory::create(['category_id' => $cats['scissors-and-tools']->id, 'slug' => 'machine-tools', 'name_fa' => 'ابزار چرخ خیاطی', 'name_en' => 'Machine Tools']);
        $subs['seam-ripper'] = Subcategory::create(['category_id' => $cats['scissors-and-tools']->id, 'slug' => 'seam-ripper', 'name_fa' => 'درفش و بشکاف', 'name_en' => 'Seam Rippers']);
        $subs['marking-tools'] = Subcategory::create(['category_id' => $cats['scissors-and-tools']->id, 'slug' => 'marking-tools', 'name_fa' => 'رولت و گچ خیاطی', 'name_en' => 'Marking Tools']);
        $subs['tailor-scissors'] = Subcategory::create(['category_id' => $cats['scissors-and-tools']->id, 'slug' => 'tailor-scissors', 'name_fa' => 'قیچی خیاطی', 'name_en' => 'Tailor Scissors']);
        $subs['embroidery-scissors'] = Subcategory::create(['category_id' => $cats['scissors-and-tools']->id, 'slug' => 'embroidery-scissors', 'name_fa' => 'قیچی گلدوزی', 'name_en' => 'Embroidery Scissors']);
        $subs['measuring-tools'] = Subcategory::create(['category_id' => $cats['scissors-and-tools']->id, 'slug' => 'measuring-tools', 'name_fa' => 'متر و اندازه‌گیری', 'name_en' => 'Measuring Tools']);
        $subs['crochet-hook'] = Subcategory::create(['category_id' => $cats['yarn-and-knitting']->id, 'slug' => 'crochet-hook', 'name_fa' => 'قلاب بافی', 'name_en' => 'Crochet Hooks']);
        $subs['yarn'] = Subcategory::create(['category_id' => $cats['yarn-and-knitting']->id, 'slug' => 'yarn', 'name_fa' => 'کاموا', 'name_en' => 'Yarn']);
        $subs['knitting-kit'] = Subcategory::create(['category_id' => $cats['yarn-and-knitting']->id, 'slug' => 'knitting-kit', 'name_fa' => 'کیت بافتنی', 'name_en' => 'Knitting Kits']);
        $subs['knitting-accessories'] = Subcategory::create(['category_id' => $cats['yarn-and-knitting']->id, 'slug' => 'knitting-accessories', 'name_fa' => 'لوازم جانبی بافت', 'name_en' => 'Knitting Accessories']);
        $subs['knitting-needles'] = Subcategory::create(['category_id' => $cats['yarn-and-knitting']->id, 'slug' => 'knitting-needles', 'name_fa' => 'میل بافتنی', 'name_en' => 'Knitting Needles']);
        $subs['macrame-cord'] = Subcategory::create(['category_id' => $cats['yarn-and-knitting']->id, 'slug' => 'macrame-cord', 'name_fa' => 'نخ ماکرامه', 'name_en' => 'Macrame Cord']);
        $subs['thread-stand'] = Subcategory::create(['category_id' => $cats['storage-and-bags']->id, 'slug' => 'thread-stand', 'name_fa' => 'پایه نخ و ماسموره', 'name_en' => 'Thread Stands']);
        $subs['storage-box'] = Subcategory::create(['category_id' => $cats['storage-and-bags']->id, 'slug' => 'storage-box', 'name_fa' => 'جعبه و سبد', 'name_en' => 'Storage Boxes & Baskets']);
        $subs['organizer'] = Subcategory::create(['category_id' => $cats['storage-and-bags']->id, 'slug' => 'organizer', 'name_fa' => 'سازماندهنده', 'name_en' => 'Organizers']);
        $subs['sewing-bag'] = Subcategory::create(['category_id' => $cats['storage-and-bags']->id, 'slug' => 'sewing-bag', 'name_fa' => 'کیف خیاطی', 'name_en' => 'Sewing Bags']);
        $subs['needle-case'] = Subcategory::create(['category_id' => $cats['storage-and-bags']->id, 'slug' => 'needle-case', 'name_fa' => 'کیف سوزن', 'name_en' => 'Needle Cases']);
        $subs['machine-carrier'] = Subcategory::create(['category_id' => $cats['storage-and-bags']->id, 'slug' => 'machine-carrier', 'name_fa' => 'لوازم حمل چرخ', 'name_en' => 'Machine Carriers']);
        $subs['aida-fabric'] = Subcategory::create(['category_id' => $cats['embroidery']->id, 'slug' => 'aida-fabric', 'name_fa' => 'پارچه آیدا', 'name_en' => 'Aida Fabric']);
        $subs['embroidery-hoop'] = Subcategory::create(['category_id' => $cats['embroidery']->id, 'slug' => 'embroidery-hoop', 'name_fa' => 'حلقه و قاب گلدوزی', 'name_en' => 'Embroidery Hoops']);
        $subs['embroidery-needle'] = Subcategory::create(['category_id' => $cats['embroidery']->id, 'slug' => 'embroidery-needle', 'name_fa' => 'سوزن گلدوزی', 'name_en' => 'Embroidery Needles']);
        $subs['embroidery-pattern'] = Subcategory::create(['category_id' => $cats['embroidery']->id, 'slug' => 'embroidery-pattern', 'name_fa' => 'طرح و الگوی گلدوزی', 'name_en' => 'Embroidery Patterns']);
        $subs['embroidery-kit'] = Subcategory::create(['category_id' => $cats['embroidery']->id, 'slug' => 'embroidery-kit', 'name_fa' => 'کیت گلدوزی', 'name_en' => 'Embroidery Kits']);
        $subs['embroidery-floss'] = Subcategory::create(['category_id' => $cats['embroidery']->id, 'slug' => 'embroidery-floss', 'name_fa' => 'نخ گلدوزی', 'name_en' => 'Embroidery Floss']);
        $subs['sequins'] = Subcategory::create(['category_id' => $cats['beads-sequins']->id, 'slug' => 'sequins', 'name_fa' => 'پولک', 'name_en' => 'Sequins']);
        $subs['decorative-stones'] = Subcategory::create(['category_id' => $cats['beads-sequins']->id, 'slug' => 'decorative-stones', 'name_fa' => 'سنگ تزئینی', 'name_en' => 'Decorative Stones']);
        $subs['beading-tools'] = Subcategory::create(['category_id' => $cats['beads-sequins']->id, 'slug' => 'beading-tools', 'name_fa' => 'لوازم منجوق‌کاری', 'name_en' => 'Beading Tools']);
        $subs['pearls'] = Subcategory::create(['category_id' => $cats['beads-sequins']->id, 'slug' => 'pearls', 'name_fa' => 'مروارید', 'name_en' => 'Pearls']);
        $subs['beads'] = Subcategory::create(['category_id' => $cats['beads-sequins']->id, 'slug' => 'beads', 'name_fa' => 'منجوق', 'name_en' => 'Beads']);
        $subs['rhinestones'] = Subcategory::create(['category_id' => $cats['beads-sequins']->id, 'slug' => 'rhinestones', 'name_fa' => 'نگین چسبی', 'name_en' => 'Rhinestones']);
        $subs['pins-and-clips'] = Subcategory::create(['category_id' => $cats['thread-and-needle']->id, 'slug' => 'pins-and-clips', 'name_fa' => 'سنجاق و گیره', 'name_en' => 'Pins & Clips']);
        $subs['machine-needle'] = Subcategory::create(['category_id' => $cats['thread-and-needle']->id, 'slug' => 'machine-needle', 'name_fa' => 'سوزن چرخ خیاطی', 'name_en' => 'Machine Needles']);
        $subs['hand-needle'] = Subcategory::create(['category_id' => $cats['thread-and-needle']->id, 'slug' => 'hand-needle', 'name_fa' => 'سوزن دوخت دستی', 'name_en' => 'Hand-Sewing Needles']);
        $subs['darning'] = Subcategory::create(['category_id' => $cats['thread-and-needle']->id, 'slug' => 'darning', 'name_fa' => 'لوازم رفوگری', 'name_en' => 'Darning Supplies']);
        $subs['bobbin'] = Subcategory::create(['category_id' => $cats['thread-and-needle']->id, 'slug' => 'bobbin', 'name_fa' => 'ماسموره و بابین', 'name_en' => 'Bobbins & Spools']);
        $subs['sewing-thread'] = Subcategory::create(['category_id' => $cats['thread-and-needle']->id, 'slug' => 'sewing-thread', 'name_fa' => 'نخ دوخت', 'name_en' => 'Sewing Threads']);

        /* ---------------- products ---------------- */
        $prods = [];
        $prods[] = Product::create([
            'name_fa' => 'نخ دوخت پلی‌استر مشکی ۵۰۰۰ متر', 'name_en' => 'Black Polyester Sewing Thread 5000m',
            'desc_fa' => 'نخ دوخت پلی‌استر با استحکام بالا و مقاوم در برابر کشیدگی. مناسب دوخت لباس، پرده و منسوجات خانگی. رنگ مشکی ثابت و کم‌رنگ‌دهی.', 'desc_en' => 'High-strength polyester sewing thread, resistant to stretching. Ideal for garments, curtains and everyday sewing.',
            'price' => 49400, 'stock' => 25,
            'category_id' => $cats['thread-and-needle']->id, 'subcategory_id' => $subs['sewing-thread']->id,
            'image' => 'images/products/peransa-1.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'نخ دوخت پلی‌استر سفید ۵۰۰۰ متر', 'name_en' => 'White Polyester Sewing Thread 5000m',
            'desc_fa' => 'نخ دوخت پلی‌استر سفید با پیچش یکنواخت. مناسب دوخت‌های روشن و لباس‌های سفید. مقاوم در برابر شست‌وشو.', 'desc_en' => 'Durable white polyester thread for light fabrics, hems and overlock finishing. Smooth, lint-free run.',
            'price' => 46800, 'stock' => 32,
            'category_id' => $cats['thread-and-needle']->id, 'subcategory_id' => $subs['sewing-thread']->id,
            'image' => 'images/products/peransa-2.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'نخ دوخت نخی رنگ‌بندی ۱۲ عددی', 'name_en' => 'Cotton Sewing Thread Set — 12 Colors',
            'desc_fa' => 'بستهٔ ۱۲ عددی نخ دوخت نخی در رنگ‌های پرکاربرد. برای دوخت‌های دستی و رفوکاری مناسب است و رنگ‌ها در برابر نور ثابت می‌مانند.', 'desc_en' => 'Assorted cotton sewing threads in 12 colors — perfect for repairs, quilting and hand stitching.',
            'price' => 173880, 'stock' => 39,
            'category_id' => $cats['thread-and-needle']->id, 'subcategory_id' => $subs['sewing-thread']->id,
            'image' => 'images/products/peransa-3.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'سوزن دوخت دستی بلند بسته ۲۵ عددی', 'name_en' => 'Long Hand-Sewing Needles — Pack of 25',
            'desc_fa' => 'سوزن دوخت دستی بلند با چشم گشاد و نوک تیز. مناسب دوخت پارچه‌های ضخیم و متوسط. بستهٔ ۲۵ عددی در ظرف نگهدارنده.', 'desc_en' => 'Slim long hand-sewing needles, pack of 25. Great for basting, tailoring and thick layers.',
            'price' => 33440, 'stock' => 46,
            'category_id' => $cats['thread-and-needle']->id, 'subcategory_id' => $subs['hand-needle']->id,
            'image' => 'images/products/peransa-4.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'سوزن دوخت دستی کوتاه بسته ۲۵ عددی', 'name_en' => 'Short Hand-Sewing Needles — Pack of 25',
            'desc_fa' => 'سوزن دوخت دستی کوتاه برای کارهای ظریف و دوخت‌های دقیق. نوک تیز و صیقلی که پارچه را نمی‌درد.', 'desc_en' => 'Short hand-sewing needles, pack of 25. Precise points for fine, detailed handwork.',
            'price' => 29440, 'stock' => 53,
            'category_id' => $cats['thread-and-needle']->id, 'subcategory_id' => $subs['hand-needle']->id,
            'image' => 'images/products/peransa-5.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'سوزن چرخ خیاطی یونیورسال بسته ۱۰ عددی', 'name_en' => 'Universal Sewing Machine Needles — Pack of 10',
            'desc_fa' => 'سوزن چرخ خیاطی یونیورسال مناسب اکثر پارچه‌های معمولی. بستهٔ ۱۰ عددی. سازگار با چرخ‌های خانگی رایج.', 'desc_en' => 'Universal sewing machine needles, pack of 10. Fits all home machines for woven and knit fabrics.',
            'price' => 40500, 'stock' => 18,
            'category_id' => $cats['thread-and-needle']->id, 'subcategory_id' => $subs['machine-needle']->id,
            'image' => 'images/products/peransa-6.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'سوزن چرخ خیاطی مخصوص جین', 'name_en' => 'Jeans Sewing Machine Needles',
            'desc_fa' => 'سوزن چرخ مخصوص دوخت پارچه‌های سنگین مانند جین و کتان ضخیم. نوک مقاوم و سوراخ چشم بزرگ‌تر.', 'desc_en' => 'Special jeans/denim machine needles with reinforced shaft — punches through heavy layers without breaking.',
            'price' => 55100, 'stock' => 25,
            'category_id' => $cats['thread-and-needle']->id, 'subcategory_id' => $subs['machine-needle']->id,
            'image' => 'images/products/peransa-7.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'نخ گلدوزی پنبه‌ای رنگ‌بندی ۲۴ رنگ', 'name_en' => 'Cotton Embroidery Floss — 24 Colors',
            'desc_fa' => 'بستهٔ ۲۴ رنگ نخ گلدوزی پنبه‌ای مرسریزه. درخشندگی خوب و ثبات رنگ بالا. مناسب گلدوزی دستی و شماره‌دوزی.', 'desc_en' => 'Cotton embroidery floss in 24 vibrant colors. Soft sheen, color-fast for cross-stitch and embroidery.',
            'price' => 245000, 'stock' => 32,
            'category_id' => $cats['embroidery']->id, 'subcategory_id' => $subs['embroidery-floss']->id,
            'image' => 'images/products/peransa-8.jpg', 'featured' => true,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'نخ گلدوزی ابریشمی رنگ‌بندی ۱۲ رنگ', 'name_en' => 'Silk Embroidery Floss — 12 Colors',
            'desc_fa' => 'نخ گلدوزی ابریشمی با درخشندگی بالا در ۱۲ رنگ. مناسب گلدوزی طرح‌های گل و کارهای تزئینی.', 'desc_en' => 'Silk embroidery floss, 12 rich colors with a luxurious gloss for premium embroidery work.',
            'price' => 182160, 'stock' => 39,
            'category_id' => $cats['embroidery']->id, 'subcategory_id' => $subs['embroidery-floss']->id,
            'image' => 'images/products/peransa-9.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'نخ متالیک طلایی گلدوزی', 'name_en' => 'Gold Metallic Embroidery Thread',
            'desc_fa' => 'نخ متالیک با روکش طلایی برای گلدوزی‌های تزئینی و برجسته. مناسب طرح‌های مجلسی و تزئین لباس.', 'desc_en' => 'Gold metallic embroidery thread for festive, decorative and raised embroidery on evening wear.',
            'price' => 90250, 'stock' => 46,
            'category_id' => $cats['embroidery']->id, 'subcategory_id' => $subs['embroidery-floss']->id,
            'image' => 'images/products/peransa-10.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'حلقه گلدوزی چوبی ۲۰ سانتی', 'name_en' => 'Wooden Embroidery Hoop 20cm',
            'desc_fa' => 'حلقه گلدوزی چوبی با قطر ۲۰ سانتی‌متر و پیچ تنظیم. سطح صیقلی که به پارچه آسیب نمی‌زند.', 'desc_en' => 'Solid wooden embroidery hoop, 20cm diameter with smooth polished rim and adjustable screw.',
            'price' => 148500, 'stock' => 53,
            'category_id' => $cats['embroidery']->id, 'subcategory_id' => $subs['embroidery-hoop']->id,
            'image' => 'images/products/peransa-11.jpg', 'featured' => true,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'حلقه گلدوزی پلاستیکی ۱۵ سانتی', 'name_en' => 'Plastic Embroidery Hoop 15cm',
            'desc_fa' => 'حلقه گلدوزی پلاستیکی سبک با قطر ۱۵ سانتی‌متر. مناسب کارهای کوچک و تمرینی. دارای پیچ تنظیم.', 'desc_en' => 'Lightweight plastic embroidery hoop, 15cm — perfect for small projects and practice.',
            'price' => 71760, 'stock' => 18,
            'category_id' => $cats['embroidery']->id, 'subcategory_id' => $subs['embroidery-hoop']->id,
            'image' => 'images/products/peransa-12.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'پارچه آیدا ۱۴ خانه رنگ سفید', 'name_en' => 'White Aida Cloth — 14 Count',
            'desc_fa' => 'پارچه آیدا با ۱۴ خانه در اینچ و رنگ سفید. پایه‌ای استاندارد برای شماره‌دوزی و گلدوزی شماتیک.', 'desc_en' => 'Classic white Aida cloth, 14-count — the standard evenweave base for cross-stitch and embroidery.',
            'price' => 130640, 'stock' => 25,
            'category_id' => $cats['embroidery']->id, 'subcategory_id' => $subs['aida-fabric']->id,
            'image' => 'images/products/peransa-13.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'کیت گلدوزی مبتدی با حلقه و نخ', 'name_en' => 'Beginner Embroidery Kit with Hoop & Thread',
            'desc_fa' => 'کیت کامل گلدوزی برای شروع‌کنندگان شامل حلقه، نخ رنگ‌بندی، سوزن و پارچه. همراه با راهنمای تصویری فارسی.', 'desc_en' => 'Complete beginner embroidery kit: hoop, colored threads, needles and fabric to start right away.',
            'price' => 260100, 'stock' => 32,
            'category_id' => $cats['embroidery']->id, 'subcategory_id' => $subs['embroidery-kit']->id,
            'image' => 'images/products/peransa-14.jpg', 'featured' => true,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'کیت گلدوزی طرح گل رز', 'name_en' => 'Rose Pattern Embroidery Kit',
            'desc_fa' => 'کیت گلدوزی با طرح گل رز و راهنمای گام‌به‌گام. شامل تمام نخ‌های موردنیاز و حلقه گلدوزی.', 'desc_en' => 'Rose-pattern embroidery kit with step-by-step guide, all threads and hoop included.',
            'price' => 324900, 'stock' => 39,
            'category_id' => $cats['embroidery']->id, 'subcategory_id' => $subs['embroidery-kit']->id,
            'image' => 'images/products/peransa-15.jpg', 'featured' => true,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'روبان ساتن عرض ۱ سانتی رنگ‌بندی', 'name_en' => 'Satin Ribbon 1cm — Assorted Colors',
            'desc_fa' => 'روبان ساتن با عرض ۱ سانتی‌متر و بافت براق. در رنگ‌های متنوع برای تزئین لباس، کادو و کارهای هنری.', 'desc_en' => 'Glossy satin ribbon, 1cm width in assorted colors for gift wrapping, garments and crafts.',
            'price' => 38640, 'stock' => 46,
            'category_id' => $cats['ribbon-lace-tulle']->id, 'subcategory_id' => $subs['satin-ribbon']->id,
            'image' => 'images/products/peransa-16.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'روبان ساتن عرض ۲ سانتی رنگ‌بندی', 'name_en' => 'Satin Ribbon 2cm — Assorted Colors',
            'desc_fa' => 'روبان ساتن با عرض ۲ سانتی‌متر. مناسب تزئین لباس مجلسی، گل‌آرایی و ساخت اکسسوری.', 'desc_en' => 'Satin ribbon, 2cm width in assorted colors — smooth weave with elegant sheen.',
            'price' => 61200, 'stock' => 53,
            'category_id' => $cats['ribbon-lace-tulle']->id, 'subcategory_id' => $subs['satin-ribbon']->id,
            'image' => 'images/products/peransa-17.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'روبان ساتن پهن ۵ سانتی', 'name_en' => 'Wide Satin Ribbon 5cm',
            'desc_fa' => 'روبان ساتن پهن ۵ سانتی‌متر با بافت درشت. مناسب کمربند پارچه‌ای، تزئین پرده و ساخت گل روبان.', 'desc_en' => 'Wide 5cm satin ribbon for bows, drapery accents and statement decorations.',
            'price' => 115000, 'stock' => 18,
            'category_id' => $cats['ribbon-lace-tulle']->id, 'subcategory_id' => $subs['satin-ribbon']->id,
            'image' => 'images/products/peransa-18.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'روبان مخمل عرض ۱ سانتی', 'name_en' => 'Velvet Ribbon 1cm',
            'desc_fa' => 'روبان مخمل با عرض ۱ سانتی‌متر و سطح نمدی. حس لوکس و مناسب تزئین لباس مجلسی و کارت.', 'desc_en' => 'Soft velvet ribbon, 1cm width — rich texture for luxury packaging and evening garments.',
            'price' => 79200, 'stock' => 25,
            'category_id' => $cats['ribbon-lace-tulle']->id, 'subcategory_id' => $subs['velvet-ribbon']->id,
            'image' => 'images/products/peransa-19.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'روبان چاپی گلدار', 'name_en' => 'Floral Printed Ribbon',
            'desc_fa' => 'روبان با چاپ گلدار و رنگ‌های شاد. مناسب تزئین لباس کودک، کاردستی و بسته‌بندی هدیه.', 'desc_en' => 'Floral printed ribbon with vivid colors — perfect for decorative bands and gift boxes.',
            'price' => 68080, 'stock' => 32,
            'category_id' => $cats['ribbon-lace-tulle']->id, 'subcategory_id' => $subs['printed-ribbon']->id,
            'image' => 'images/products/peransa-20.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'دانتل گلدار عرض ۵ سانتی', 'name_en' => 'Floral Guipure Lace 5cm',
            'desc_fa' => 'دانتل گلدار با عرض ۵ سانتی‌متر و بافت ظریف. مناسب لبه‌دوزی لباس، رومیزی و پرده.', 'desc_en' => 'Floral guipure lace, 5cm width — elegant trim for dresses, blouses and bridal wear.',
            'price' => 142200, 'stock' => 39,
            'category_id' => $cats['ribbon-lace-tulle']->id, 'subcategory_id' => $subs['lace-guipure']->id,
            'image' => 'images/products/peransa-21.jpg', 'featured' => true,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'تور ساده سفید ۳ متری', 'name_en' => 'Plain White Tulle — 3 Meters',
            'desc_fa' => 'تور ساده سفید به طول ۳ متر. مناسب زیر دامن، تزئین لباس عروس و کارهای هنری.', 'desc_en' => 'Plain white tulle, 3 meters — soft netting for veils, skirts and event decoration.',
            'price' => 121440, 'stock' => 46,
            'category_id' => $cats['ribbon-lace-tulle']->id, 'subcategory_id' => $subs['tulle']->id,
            'image' => 'images/products/peransa-22.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'کاموا اکریلیک ضخیم رنگ‌بندی', 'name_en' => 'Thick Acrylic Yarn — Assorted Colors',
            'desc_fa' => 'کاموا اکریلیک ضخیم با متراژ مناسب بافت شال، کلاه و پتو. نرم و ضدحساسیت. رنگ‌بندی متنوع.', 'desc_en' => 'Thick acrylic yarn in assorted colors — warm, durable and easy-care for winter knitting.',
            'price' => 90160, 'stock' => 53,
            'category_id' => $cats['yarn-and-knitting']->id, 'subcategory_id' => $subs['yarn']->id,
            'image' => 'images/products/peransa-23.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'کاموا پشمی نرم زمستانی', 'name_en' => 'Soft Winter Wool Yarn',
            'desc_fa' => 'کاموا پشمی نرم مناسب بافت لباس زمستانی. گرمای بالا و حس لطیف روی پوست.', 'desc_en' => 'Soft winter wool yarn with gentle hand-feel — cozy sweaters, scarves and hats.',
            'price' => 154560, 'stock' => 18,
            'category_id' => $cats['yarn-and-knitting']->id, 'subcategory_id' => $subs['yarn']->id,
            'image' => 'images/products/peransa-24.jpg', 'featured' => true,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'میل بافتنی فلزی سایز ۳', 'name_en' => 'Metal Knitting Needles Size 3',
            'desc_fa' => 'میل بافتنی فلزی سایز ۳ با سطح صیقلی. مناسب بافت نخ‌های نازک و کارهای ظریف.', 'desc_en' => 'Metal knitting needles size 3 — smooth tips and polished shaft for fast, even stitches.',
            'price' => 55800, 'stock' => 25,
            'category_id' => $cats['yarn-and-knitting']->id, 'subcategory_id' => $subs['knitting-needles']->id,
            'image' => 'images/products/peransa-25.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'میل بافتنی چوبی ست ۵ سایز', 'name_en' => 'Wooden Knitting Needle Set — 5 Sizes',
            'desc_fa' => 'ست ۵ سایز میل بافتنی چوبی از سایز ۳ تا ۸. سطح چوبی گرم که نخ روی آن سُر نمی‌خورد.', 'desc_en' => 'Wooden knitting needle set, 5 sizes — warm touch and light weight for long projects.',
            'price' => 193500, 'stock' => 32,
            'category_id' => $cats['yarn-and-knitting']->id, 'subcategory_id' => $subs['knitting-needles']->id,
            'image' => 'images/products/peransa-26.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'قلاب بافی آلومینیومی ست ۸ عددی', 'name_en' => 'Aluminum Crochet Hook Set — 8 Pieces',
            'desc_fa' => 'ست ۸ عددی قلاب بافی آلومینیومی در سایزهای مختلف. دسته ارگونومیک برای استفاده طولانی.', 'desc_en' => 'Aluminum crochet hook set, 8 pieces with ergonomic grips for all yarn weights.',
            'price' => 163760, 'stock' => 39,
            'category_id' => $cats['yarn-and-knitting']->id, 'subcategory_id' => $subs['crochet-hook']->id,
            'image' => 'images/products/peransa-27.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'نشانگر بافت بسته ۳۰ عددی', 'name_en' => 'Stitch Markers — Pack of 30',
            'desc_fa' => 'نشانگر بافت پلاستیکی رنگی در بستهٔ ۳۰ عددی. برای علامت‌گذاری محل کاهش و افزایش دانه.', 'desc_en' => 'Stitch markers, pack of 30 — essential for counting and securing knitting and crochet rows.',
            'price' => 45000, 'stock' => 46,
            'category_id' => $cats['yarn-and-knitting']->id, 'subcategory_id' => $subs['knitting-accessories']->id,
            'image' => 'images/products/peransa-28.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'دکمه پلاستیکی ۴ سوراخ بسته ۱۰۰ عددی', 'name_en' => 'Plastic 4-Hole Buttons — Pack of 100',
            'desc_fa' => 'دکمه پلاستیکی ۴ سوراخ در بستهٔ ۱۰۰ عددی. لبه صیقلی و مقاوم در برابر شست‌وشو. رنگ مشکی و سفید.', 'desc_en' => 'Plastic 4-hole buttons, pack of 100 in black and white. Polished edges, wash-resistant.',
            'price' => 62560, 'stock' => 53,
            'category_id' => $cats['buttons-zippers']->id, 'subcategory_id' => $subs['buttons']->id,
            'image' => 'images/products/peransa-29.jpg', 'featured' => true,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'دکمه صدفی لباس مجلسی', 'name_en' => 'Shell Button for Evening Dresses',
            'desc_fa' => 'دکمه صدفی با درخشندگی طبیعی. مناسب لباس مجلسی، بلوز و پیراهن. بستهٔ ۵۰ عددی.', 'desc_en' => 'Elegant shell button for evening dresses — natural pearlescent glow with fine faceting.',
            'price' => 127800, 'stock' => 18,
            'category_id' => $cats['buttons-zippers']->id, 'subcategory_id' => $subs['buttons']->id,
            'image' => 'images/products/peransa-30.jpg', 'featured' => true,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'زیپ مخفی ۳۰ سانتی رنگ‌بندی', 'name_en' => 'Invisible Zipper 30cm — Assorted Colors',
            'desc_fa' => 'زیپ مخفی ۳۰ سانتی‌متر با کشویی نرم. مناسب دوخت لباس، دامن و پیراهن. در رنگ‌های هم‌رنگ پارچه.', 'desc_en' => 'Invisible zipper 30cm in assorted colors — clean concealed closure for dresses and cushions.',
            'price' => 34960, 'stock' => 25,
            'category_id' => $cats['buttons-zippers']->id, 'subcategory_id' => $subs['zippers']->id,
            'image' => 'images/products/peransa-31.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'زیپ فلزی ۲۰ سانتی مشکی', 'name_en' => 'Metal Zipper 20cm — Black',
            'desc_fa' => 'زیپ فلزی ۲۰ سانتی‌متر با دندانه فلزی مقاوم. مناسب شلوار جین، کیف و کاپشن.', 'desc_en' => 'Sturdy black metal zipper, 20cm with smooth slider for jackets, bags and heavy fabrics.',
            'price' => 48600, 'stock' => 32,
            'category_id' => $cats['buttons-zippers']->id, 'subcategory_id' => $subs['zippers']->id,
            'image' => 'images/products/peransa-32.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'قزن کیف فلزی طلایی', 'name_en' => 'Gold Metal Bag Clasp',
            'desc_fa' => 'قزن کیف فلزی با روکش طلایی. ظاهر شیک و قفل محکم. مناسب کیف دستی و کوله.', 'desc_en' => 'Gold metal bag clasp — premium hardware finish for handmade and luxury bags.',
            'price' => 81880, 'stock' => 39,
            'category_id' => $cats['buttons-zippers']->id, 'subcategory_id' => $subs['clasps']->id,
            'image' => 'images/products/peransa-33.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'کش باریک لباس بسته ۵ متری', 'name_en' => 'Narrow Clothing Elastic — 5 Meters',
            'desc_fa' => 'کش باریک لباس به طول ۵ متر. کشسانی بالا و برگشت‌پذیری خوب. مناسب کمر لباس و آستین.', 'desc_en' => 'Narrow clothing elastic, 5-meter roll — reliable stretch for waistbands and cuffs.',
            'price' => 38640, 'stock' => 46,
            'category_id' => $cats['buttons-zippers']->id, 'subcategory_id' => $subs['elastic-band']->id,
            'image' => 'images/products/peransa-34.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'قیچی خیاطی ۸ اینچ حرفه‌ای', 'name_en' => 'Professional Tailor Scissors 8"',
            'desc_fa' => 'قیچی خیاطی ۸ اینچ با تیغه فولادی ضدزنگ و پیچ تنظیم. برش دقیق و راحت حتی روی چند لایه پارچه.', 'desc_en' => 'Professional 8" tailor scissors — razor-sharp blades for precise fabric cutting.',
            'price' => 616500, 'stock' => 53,
            'category_id' => $cats['scissors-and-tools']->id, 'subcategory_id' => $subs['tailor-scissors']->id,
            'image' => 'images/products/peransa-35.jpg', 'featured' => true,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'قیچی خیاطی ۱۰ اینچ برش پارچه', 'name_en' => 'Fabric Cutting Scissors 10"',
            'desc_fa' => 'قیچی خیاطی ۱۰ اینچ مخصوص برش پارچه‌های ضخیم. دسته ارگونومیک و تیغه بلند برای برش سریع.', 'desc_en' => '10" fabric cutting scissors — long clean cuts through multiple layers with ease.',
            'price' => 802800, 'stock' => 18,
            'category_id' => $cats['scissors-and-tools']->id, 'subcategory_id' => $subs['tailor-scissors']->id,
            'image' => 'images/products/peransa-36.jpg', 'featured' => true,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'قیچی گلدوزی نوک‌کج', 'name_en' => 'Curved Embroidery Scissors',
            'desc_fa' => 'قیچی گلدوزی با نوک کج و تیغه ظریف. مناسب کارهای دقیق، بریدن نخ و گلدوزی دستی.', 'desc_en' => 'Curved embroidery scissors — fine pointed blades for trimming threads in tight areas.',
            'price' => 169280, 'stock' => 25,
            'category_id' => $cats['scissors-and-tools']->id, 'subcategory_id' => $subs['embroidery-scissors']->id,
            'image' => 'images/products/peransa-37.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'درفش خیاطی با دسته چوبی', 'name_en' => 'Seam Ripper with Wooden Handle',
            'desc_fa' => 'درفش خیاطی با دسته چوبی و نوک فولادی. برای باز کردن بخیه و بیرون کشیدن نخ کاربرد دارد.', 'desc_en' => 'Seam ripper with comfortable wooden handle — quick, safe stitch removal.',
            'price' => 86400, 'stock' => 32,
            'category_id' => $cats['scissors-and-tools']->id, 'subcategory_id' => $subs['seam-ripper']->id,
            'image' => 'images/products/peransa-38.jpg', 'featured' => false,
        ]);
        $prods[] = Product::create([
            'name_fa' => 'متر خیاطی ۱۵۰ سانتی', 'name_en' => 'Tailor Tape Measure 150cm',
            'desc_fa' => 'متر خیاطی پارچه‌ای ۱۵۰ سانتی با دو طرف مدرج. انعطاف‌پذیر و مناسب اندازه‌گیری اندام.', 'desc_en' => 'Tailor tape measure, 150cm with clear markings on both sides for accurate body measurements.',
            'price' => 53360, 'stock' => 39,
            'category_id' => $cats['scissors-and-tools']->id, 'subcategory_id' => $subs['measuring-tools']->id,
            'image' => 'images/products/peransa-39.jpg', 'featured' => false,
        ]);

        /* ---------------- sample reviews ---------------- */
        Review::create(['product_id' => $prods[28]->id, 'author_name' => 'مریم احمدی', 'rating' => 5, 'comment' => 'کیفیت دکمه‌ها عالیه، دقیقاً مثل عکس. برای دوخت مانتو استفاده کردم.', 'status' => 'approved']);
        Review::create(['product_id' => $prods[29]->id, 'author_name' => 'زهرا کریمی', 'rating' => 5, 'comment' => 'دکمه صدفی واقعاً شیکه، روی پیراهن مجلسی فوق‌العاده شد.', 'status' => 'approved']);
        Review::create(['product_id' => $prods[34]->id, 'author_name' => 'علی رحیمی', 'rating' => 5, 'comment' => 'قیچی حرفه‌ای و تیز، دسته‌ش هم خیلی راحته. ارزش خرید داره.', 'status' => 'approved']);
        Review::create(['product_id' => $prods[23]->id, 'author_name' => 'الهام محمدی', 'rating' => 5, 'comment' => 'کاموا نرم و گرمه، بافتنی زمستانی عالی شد.', 'status' => 'approved']);
        Review::create(['product_id' => $prods[14]->id, 'author_name' => 'ترانه کاظمی', 'rating' => 5, 'comment' => 'کیت کامل و باکیفیت، راهنماش هم خیلی کمک‌کننده بود.', 'status' => 'approved']);
        Review::create(['product_id' => $prods[20]->id, 'author_name' => 'نگار رضایی', 'rating' => 4, 'comment' => 'دانتل ظریف و خوشگله، رنگش هم مثل عکسه.', 'status' => 'approved']);
        Review::create(['product_id' => $prods[7]->id, 'author_name' => 'فاطمه نجفی', 'rating' => 5, 'comment' => 'نخ‌های گلدوزی رنگ‌های شاد و ثابتی دارن.', 'status' => 'approved']);
        Review::create(['product_id' => $prods[30]->id, 'author_name' => 'امیر حسینی', 'rating' => 4, 'comment' => 'زیپ مخفی باکیفیت، روی لباس تمیز درمیاد.', 'status' => 'approved']);
        Review::create(['product_id' => $prods[10]->id, 'author_name' => 'مهسا اکبری', 'rating' => 5, 'comment' => 'حلقه چوبی محکمه و پارچه رو خوب نگه می‌داره.', 'status' => 'approved']);
        Review::create(['product_id' => $prods[38]->id, 'author_name' => 'سارا موسوی', 'rating' => 5, 'comment' => 'متر دقیق و خوش‌دست، برای خیاطی عالیه.', 'status' => 'approved']);

        $this->command?->info('Peransa catalog seeded: ' . Product::count() . ' products, ' . Category::count() . ' categories, ' . Subcategory::count() . ' subs, ' . Review::count() . ' reviews');
    }
}
