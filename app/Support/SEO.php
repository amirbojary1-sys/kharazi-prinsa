<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;

/**
 * SEO helpers: meta + Open Graph + hreflang + JSON-LD.
 */
class SEO
{
    /** Default meta description per page key. */
    public static function desc(?string $override = null): string
    {
        return trim($override ?: __('messages.meta_default_desc'));
    }

    /** hreflang alternate URLs for the current page (?lang=). */
    public static function alternates(): array
    {
        $url = url()->current();
        $query = request()->except('lang');
        $fa = $url . (empty($query) ? '' : '?' . http_build_query($query)) . (empty($query) ? '?lang=fa' : '&lang=fa');
        $en = $url . (empty($query) ? '' : '?' . http_build_query($query)) . (empty($query) ? '?lang=en' : '&lang=en');
        return ['fa' => $fa, 'en' => $en, 'x-default' => $fa];
    }

    /** Organization + WebSite schema (site-wide). */
    public static function orgSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@graph'   => [
                [
                    '@type'    => 'Organization',
                    '@id'      => route('home') . '#org',
                    'name'     => __('messages.brand'),
                    'url'      => route('home'),
                    'logo'     => asset('images/hero-cinematic.jpg'),
                    'sameAs'   => ['https://instagram.com/kharazi.prinsa', 'https://t.me/kharazi.prinsa'],
                    'contactPoint' => [
                        '@type'       => 'ContactPoint',
                        'telephone'   => '+98-21-44556677',
                        'contactType' => 'customer service',
                        'areaServed'  => 'IR',
                        'availableLanguage' => ['Persian', 'English'],
                    ],
                ],
                [
                    '@type'   => 'WebSite',
                    '@id'     => route('home') . '#website',
                    'url'     => route('home'),
                    'name'    => __('messages.brand'),
                    'publisher' => ['@id' => route('home') . '#org'],
                    'potentialAction' => [
                        '@type'       => 'SearchAction',
                        'target'      => route('shop') . '?q={search_term_string}',
                        'query-input' => 'required name=search_term_string',
                    ],
                ],
            ],
        ];
    }

    /** Product schema with offers + rating + reviews. */
    public static function productSchema($product): array
    {
        $reviews = $product->approvedReviews;
        $avg = $product->avgRating();

        $data = [
            '@context' => 'https://schema.org',
            '@type'    => 'Product',
            'name'     => $product->name,
            'image'    => array_map(fn ($g) => asset($g), $product->gallery()),
            'description' => mb_substr(strip_tags($product->desc), 0, 500),
            'sku'      => 'PR-' . $product->id,
            'brand'    => ['@type' => 'Brand', 'name' => __('messages.brand')],
            'offers'   => [
                '@type'         => 'Offer',
                'url'           => route('product', $product->id),
                'priceCurrency' => 'IRR',
                'price'         => $product->price,
                'availability'  => $product->stock > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                'itemCondition' => 'https://schema.org/NewCondition',
            ],
        ];

        if ($avg && $reviews->count()) {
            $data['aggregateRating'] = [
                '@type'       => 'AggregateRating',
                'ratingValue' => $avg,
                'reviewCount' => $reviews->count(),
                'bestRating'  => 5,
                'worstRating' => 1,
            ];
            $data['review'] = $reviews->take(8)->map(fn ($r) => [
                '@type'        => 'Review',
                'author'       => ['@type' => 'Person', 'name' => $r->author_name],
                'datePublished' => $r->created_at->toDateString(),
                'reviewRating' => ['@type' => 'Rating', 'ratingValue' => $r->rating, 'bestRating' => 5],
                'reviewBody'   => mb_substr($r->comment, 0, 400),
            ])->values()->all();
        }

        return $data;
    }

    /** BreadcrumbList schema. */
    public static function breadcrumbSchema(array $items): array
    {
        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => array_values(array_map(fn ($it, $i) => [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $it['name'],
                'item'     => $it['url'] ?? null,
            ], $items, array_keys($items))),
        ];
    }
}
