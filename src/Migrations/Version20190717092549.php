<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190717092549 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $pages = [
            'homepage' => [
                'id' => 1,
                'parent_id' => 'null',
                'name' => 'Homepage',
                'level' => 1,

                'change_frequency' => 'daily',
                'route' => 'homepage',
                'priority' => '0.9',
                'has_meta_title' => 1,
                'has_meta_keywords' => 1,
                'has_meta_description' => 1,
                'has_content' => 0,
                'controller_action' => 'App\\\Controller\\\Frontend\\\MainController::index',
                'template' => 'Main\\\index.html.twig',

                'translations' => [
                    'en' => [
                        'url' => '/en',
                        'meta_title' => '',
                        'meta_keywords' => '',
                        'meta_description' => '',
                        'content' => '',
                    ],
                    'de' => [
                        'url' => '/de',
                        'meta_title' => '',
                        'meta_keywords' => '',
                        'meta_description' => '',
                        'content' => '',
                    ],
                ]
            ],

            'impressum' => [
                'id' => 11,
                'parent_id' => 1,
                'name' => 'Impressum',
                'level' => 2,

                'change_frequency' => 'weekly',
                'route' => 'impressum',
                'priority' => '0.5',
                'has_meta_title' => 1,
                'has_meta_keywords' => 1,
                'has_meta_description' => 1,
                'has_content' => 1,
                'controller_action' => 'App\\\Controller\\\Frontend\\\MainController::page',
                'template' => 'Main\\\page.html.twig',

                'translations' => [
                    'en' => [
                        'url' => '/impressum',
                        'meta_title' => '',
                        'meta_keywords' => '',
                        'meta_description' => '',
                        'content' => '',
                    ],
                    'de' => [
                        'url' => '/impressum',
                        'meta_title' => '',
                        'meta_keywords' => '',
                        'meta_description' => '',
                        'content' => '',
                    ],
                ]
            ],

            'privacy_policy' => [
                'id' => 12,
                'parent_id' => 1,
                'name' => 'Privacy Policy',
                'level' => 2,

                'change_frequency' => 'weekly',
                'route' => 'privacy_policy',
                'priority' => '0.5',
                'has_meta_title' => 1,
                'has_meta_keywords' => 1,
                'has_meta_description' => 1,
                'has_content' => 1,
                'controller_action' => 'App\\\Controller\\\Frontend\\\MainController::page',
                'template' => 'Main\\\page.html.twig',

                'translations' => [
                    'en' => [
                        'url' => '/privacy-policy',
                        'meta_title' => '',
                        'meta_keywords' => '',
                        'meta_description' => '',
                        'content' => '',
                    ],
                    'de' => [
                        'url' => '/datenschutz',
                        'meta_title' => '',
                        'meta_keywords' => '',
                        'meta_description' => '',
                        'content' => '',
                    ],
                ]
            ]
        ];

        $textConents = [
            'homepage_header' => [
                'id' => 2,
                'parent_id' => 1,
                'name' => 'Header',
                'level' => 2,

                'uid' => 'homepage_header',
                'has_title' => 1,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => 'WE ARE...',
                        'content' => '<p>Lore perovit optatur, eritias excerum dolorerit quis magnihi ligenet fuga. Et eatur rersperrum si cus esti ducium es aut modit la vit excessit quo vent, int ut quatiam nossit dolupitatur?</p>',
                    ],
                    'de' => [
                        'title' => 'WE ARE...',
                        'content' => '<p>Lore perovit optatur, eritias excerum dolorerit quis magnihi ligenet fuga. Et eatur rersperrum si cus esti ducium es aut modit la vit excessit quo vent, int ut quatiam nossit dolupitatur?</p>',
                    ],
                ]
            ],

            'homepage_what_we_do' => [
                'id' => 13,
                'parent_id' => 1,
                'name' => 'What we do',
                'level' => 2,

                'uid' => 'homepage_what_we_do',
                'has_title' => 1,
                'has_content' => 0,

                'translations' => [
                    'en' => [
                        'title' => 'What we do?',
                        'content' => '',
                    ],
                    'de' => [
                        'title' => 'What we do?',
                        'content' => '',
                    ],
                ]
            ],

            'homepage_what_we_do_1' => [
                'id' => 3,
                'parent_id' => 13,
                'name' => 'Helping Startups',
                'level' => 3,

                'uid' => 'homepage_what_we_do_1',
                'has_title' => 1,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => 'Helping Startups',
                        'content' => '<p>Create MVPs, choosing the most suitable strategy, preparing for investment rounds.</p>',
                    ],
                    'de' => [
                        'title' => 'Helping Startups',
                        'content' => '<p>Create MVPs, choosing the most suitable strategy, preparing for investment rounds.</p>',
                    ],
                ]
            ],

            'homepage_what_we_do_2' => [
                'id' => 4,
                'parent_id' => 13,
                'name' => 'Creating Products',
                'level' => 3,

                'uid' => 'homepage_what_we_do_2',
                'has_title' => 1,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => 'Creating Products',
                        'content' => '<p>Together with the businesses we drive their ideas from a single sentence to a full-fledged concept.</p>',
                    ],
                    'de' => [
                        'title' => 'Creating Products',
                        'content' => '<p>Together with the businesses we drive their ideas from a single sentence to a full-fledged concept.</p>',
                    ],
                ]
            ],

            'homepage_what_we_do_3' => [
                'id' => 5,
                'parent_id' => 13,
                'name' => 'Consulting Investors',
                'level' => 3,

                'uid' => 'homepage_what_we_do_3',
                'has_title' => 1,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => 'Consulting Investors',
                        'content' => '<p>Preparing the multi-context decision base with addressed risks for the investment.</p>',
                    ],
                    'de' => [
                        'title' => 'Consulting Investors',
                        'content' => '<p>Preparing the multi-context decision base with addressed risks for the investment.</p>',
                    ],
                ]
            ],

            'homepage_how_we_do' => [
                'id' => 14,
                'parent_id' => 1,
                'name' => 'How we do it',
                'level' => 2,

                'uid' => 'homepage_how_we_do',
                'has_title' => 1,
                'has_content' => 0,

                'translations' => [
                    'en' => [
                        'title' => 'How we do it?',
                        'content' => '',
                    ],
                    'de' => [
                        'title' => 'How we do it?',
                        'content' => '',
                    ],
                ]
            ],

            'homepage_how_we_do_1' => [
                'id' => 6,
                'parent_id' => 14,
                'name' => 'Technology',
                'level' => 3,

                'uid' => 'homepage_how_we_do_1',
                'has_title' => 1,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => 'Technology',
                        'content' => '<p>Applying technology to the business goals within our innovative flexible engineering process that is ready to virtually any requirements changes during development.</p>',
                    ],
                    'de' => [
                        'title' => 'Technology',
                        'content' => '<p>Applying technology to the business goals within our innovative flexible engineering process that is ready to virtually any requirements changes during development.</p>',
                    ],
                ]
            ],

            'homepage_how_we_do_2' => [
                'id' => 7,
                'parent_id' => 14,
                'name' => 'Knowledge',
                'level' => 3,

                'uid' => 'homepage_how_we_do_2',
                'has_title' => 1,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => 'Knowledge',
                        'content' => '<p>Training and certifying specialists. Conducting workshops and mentoring at hackathons. Publishing valuable content in trending technology topics.</p>',
                    ],
                    'de' => [
                        'title' => 'Knowledge',
                        'content' => '<p>Training and certifying specialists. Conducting workshops and mentoring at hackathons. Publishing valuable content in trending technology topics.</p>',
                    ],
                ]
            ],

            'homepage_how_we_do_3' => [
                'id' => 8,
                'parent_id' => 14,
                'name' => 'Intelligence',
                'level' => 3,

                'uid' => 'homepage_how_we_do_3',
                'has_title' => 1,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => 'Intelligence',
                        'content' => '<p>Performing business-analysis and consulting to create solutions for the businesses. Engineering product design, creating products that answer the real user needs.</p>',
                    ],
                    'de' => [
                        'title' => 'Intelligence',
                        'content' => '<p>Performing business-analysis and consulting to create solutions for the businesses. Engineering product design, creating products that answer the real user needs.</p>',
                    ],
                ]
            ],

            'homepage_how_we_do_list' => [
                'id' => 9,
                'parent_id' => 14,
                'name' => 'List',
                'level' => 3,

                'uid' => 'homepage_how_we_do_list',
                'has_title' => 0,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => '',
                        'content' => '<p><ul><li>~1362Requests processed by our custom proprietary AI daily</li><li>167 Projects completed</li><li>86 Startups consulted</li><li>26 Areas of expertise in the team</li><li>Partners from18countries</li><li>17 Team members</li><li>15 Years in the IT-business</li></ul></p>',
                    ],
                    'de' => [
                        'title' => '',
                        'content' => '<p><ul><li>~1362Requests processed by our custom proprietary AI daily</li><li>167 Projects completed</li><li>86 Startups consulted</li><li>26 Areas of expertise in the team</li><li>Partners from18countries</li><li>17 Team members</li><li>15 Years in the IT-business</li></ul></p>',
                    ],
                ]
            ],

            'homepage_business_processing' => [
                'id' => 10,
                'parent_id' => 1,
                'name' => 'Business Processing',
                'level' => 2,

                'uid' => 'homepage_business_processing',
                'has_title' => 1,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => 'Business Processing',
                        'content' => '<p>Aspelectis quos delit aut el magnimi, untinto ea pa int, que laborum quiam et magnitatur maionse quuntecae eum sequati berovid quideruntem non rendem. Imost alictis volestiusa nes quam qui atinulp arcipsam sum lanihic ipsam, ium qui dus con cuscipsum restissim et est, tet optam soles esequam everrum nis diostis expland itatur? Invenihicia dipsand igenimuscid quatur mo molupta core, omnit volorio estem nonsequo volori dolore optatio rporum quidunt, tem deliquiam harum fugit volut volupta con peligeniam lam et eatur simolum quae velit ut maionse ctaersp idelest repelignita etus simin nonseque sundae idelit, volo bea dolupis dio to dite num lab</p>',
                    ],
                    'de' => [
                        'title' => 'Business Processing',
                        'content' => '<p>Aspelectis quos delit aut el magnimi, untinto ea pa int, que laborum quiam et magnitatur maionse quuntecae eum sequati berovid quideruntem non rendem. Imost alictis volestiusa nes quam qui atinulp arcipsam sum lanihic ipsam, ium qui dus con cuscipsum restissim et est, tet optam soles esequam everrum nis diostis expland itatur? Invenihicia dipsand igenimuscid quatur mo molupta core, omnit volorio estem nonsequo volori dolore optatio rporum quidunt, tem deliquiam harum fugit volut volupta con peligeniam lam et eatur simolum quae velit ut maionse ctaersp idelest repelignita etus simin nonseque sundae idelit, volo bea dolupis dio to dite num lab</p>',
                    ],
                ]
            ],

            'homepage_business_processing_carousel' => [
                'id' => 15,
                'parent_id' => 1,
                'name' => 'Business Processing Carousel',
                'level' => 2,

                'uid' => 'homepage_business_processing_carousel',
                'has_title' => 0,
                'has_content' => 0,

                'translations' => [
                    'en' => [
                        'title' => '',
                        'content' => '',
                    ],
                    'de' => [
                        'title' => '',
                        'content' => '',
                    ],
                ]
            ],

            'homepage_business_processing_carousel_1' => [
                'id' => 16,
                'parent_id' => 15,
                'name' => '1. Donec retrum congue leo eget malesuada.',
                'level' => 3,

                'uid' => 'homepage_business_processing_carousel_1',
                'has_title' => 1,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => '1. Donec retrum congue leo eget malesuada.',
                        'content' => '',
                    ],
                    'de' => [
                        'title' => '1. Donec retrum congue leo eget malesuada.',
                        'content' => '',
                    ],
                ]
            ],

            'homepage_business_processing_carousel_2' => [
                'id' => 17,
                'parent_id' => 15,
                'name' => '2. Vestibulum ac diam sit amet quam vehicula sed.',
                'level' => 3,

                'uid' => 'homepage_business_processing_carousel_2',
                'has_title' => 1,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => '2. Vestibulum ac diam sit amet quam vehicula sed.',
                        'content' => '',
                    ],
                    'de' => [
                        'title' => '2. Vestibulum ac diam sit amet quam vehicula sed.',
                        'content' => '',
                    ],
                ]
            ],

            'homepage_business_processing_carousel_3' => [
                'id' => 18,
                'parent_id' => 15,
                'name' => '3. Donec sollicitudin molestie malesuada.',
                'level' => 3,

                'uid' => 'homepage_business_processing_carousel_3',
                'has_title' => 1,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => '3. Donec sollicitudin molestie malesuada.',
                        'content' => '',
                    ],
                    'de' => [
                        'title' => '3. Donec sollicitudin molestie malesuada.',
                        'content' => '',
                    ],
                ]
            ],

            'homepage_business_processing_carousel_4' => [
                'id' => 19,
                'parent_id' => 15,
                'name' => '4. Curabitur aliquet quam id dui posuere blandit.',
                'level' => 3,

                'uid' => 'homepage_business_processing_carousel_4',
                'has_title' => 1,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => '4. Curabitur aliquet quam id dui posuere blandit.',
                        'content' => '',
                    ],
                    'de' => [
                        'title' => '4. Curabitur aliquet quam id dui posuere blandit.',
                        'content' => '',
                    ],
                ]
            ],

            'homepage_business_processing_carousel_5' => [
                'id' => 20,
                'parent_id' => 15,
                'name' => '5. Curabitur arcu erat, accumsan id imperdiet et.',
                'level' => 3,

                'uid' => 'homepage_business_processing_carousel_5',
                'has_title' => 1,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => '5. Curabitur arcu erat, accumsan id imperdiet et.',
                        'content' => '',
                    ],
                    'de' => [
                        'title' => '5. Curabitur arcu erat, accumsan id imperdiet et.',
                        'content' => '',
                    ],
                ]
            ],

            'homepage_testimonials' => [
                'id' => 21,
                'parent_id' => 1,
                'name' => 'Testimonials',
                'level' => 2,

                'uid' => 'homepage_testimonials',
                'has_title' => 0,
                'has_content' => 0,

                'translations' => [
                    'en' => [
                        'title' => '',
                        'content' => '',
                    ],
                    'de' => [
                        'title' => '',
                        'content' => '',
                    ],
                ]
            ],

            'homepage_testimonials_1' => [
                'id' => 22,
                'parent_id' => 21,
                'name' => 'Testimonial 1',
                'level' => 3,

                'uid' => 'homepage_testimonials_1',
                'has_title' => 0,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => '',
                        'content' => '<p>Aspelectis quos delit aut el magnimi, untinto ea pa int, que laborum quiam et magnitatur maionse quuntecae eum sequati berovid quideruntem non rendem. peligeniam lam et eatur simolum quae velit ut maionse ctaersp idelest repelignita etus simin nonse</p>',
                    ],
                    'de' => [
                        'title' => '',
                        'content' => '<p>Aspelectis quos delit aut el magnimi, untinto ea pa int, que laborum quiam et magnitatur maionse quuntecae eum sequati berovid quideruntem non rendem. peligeniam lam et eatur simolum quae velit ut maionse ctaersp idelest repelignita etus simin nonse</p>',
                    ],
                ]
            ],

            'homepage_testimonials_2' => [
                'id' => 23,
                'parent_id' => 21,
                'name' => 'Testimonial 2',
                'level' => 3,

                'uid' => 'homepage_testimonials_2',
                'has_title' => 0,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => '',
                        'content' => '<p>Aspelectis quos delit aut el magnimi, untinto ea pa int, que laborum quiam et magnitatur maionse quuntecae eum sequati berovid quideruntem non rendem. Imost alictis volestiusa nes quam qui atinulp arcipsam sum lanihic ipsam, ium qui dus con cuscipsum restissim et est, tet optam soles esequam everrum nis diostis expland itatur? Invenihicia dipsand igenimuscid quatur</p>',
                    ],
                    'de' => [
                        'title' => '',
                        'content' => '<p>Aspelectis quos delit aut el magnimi, untinto ea pa int, que laborum quiam et magnitatur maionse quuntecae eum sequati berovid quideruntem non rendem. Imost alictis volestiusa nes quam qui atinulp arcipsam sum lanihic ipsam, ium qui dus con cuscipsum restissim et est, tet optam soles esequam everrum nis diostis expland itatur? Invenihicia dipsand igenimuscid quatur</p>',
                    ],
                ]
            ],

            'homepage_testimonials_3' => [
                'id' => 24,
                'parent_id' => 21,
                'name' => 'Testimonial 3',
                'level' => 3,

                'uid' => 'homepage_testimonials_3',
                'has_title' => 0,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => '',
                        'content' => '<p>Latur mo molupta core, omnit volorio estem nonsequo volori dolore optatio rporum quidunt, tem deliquiam harum fugit volut volupta con peligeniam lam et eatur simolum quae velit ut maionse ctaersp idelest repelignita etus simin nonseque sundae idelit, volo bea dolupis dio to dite num lab</p>',
                    ],
                    'de' => [
                        'title' => '',
                        'content' => '<p>Latur mo molupta core, omnit volorio estem nonsequo volori dolore optatio rporum quidunt, tem deliquiam harum fugit volut volupta con peligeniam lam et eatur simolum quae velit ut maionse ctaersp idelest repelignita etus simin nonseque sundae idelit, volo bea dolupis dio to dite num lab</p>',
                    ],
                ]
            ],

            'homepage_testimonials_4' => [
                'id' => 25,
                'parent_id' => 21,
                'name' => 'Testimonial 4',
                'level' => 3,

                'uid' => 'homepage_testimonials_4',
                'has_title' => 0,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => '',
                        'content' => '<p>Latur mo molupta core, omnit volorio estem nonsequo volori dolore optatio rporum quidunt, tem deliquiam harum fugit volut volupta con peligeniam lam et eatur simolum quae velit ut maionse ctaersp idelest repelignita etus simin nonseque sundae idelit, volo bea dolupis dio to dite num labHarum iliquae pa cum ipide si diore sunt, omnis illab inimus. Tempore volut ulpa voluptaspis re desciae reperum doluptur, omnis dundae qui core, solorem olorro berspel iquibus pra nullaci aerferorpos et facearchic temporit, vel illenihit, arum il ium estibus aborepe lluptate velit laut untiundent optam quibus, sam quate volore</p>',
                    ],
                    'de' => [
                        'title' => '',
                        'content' => '<p>Latur mo molupta core, omnit volorio estem nonsequo volori dolore optatio rporum quidunt, tem deliquiam harum fugit volut volupta con peligeniam lam et eatur simolum quae velit ut maionse ctaersp idelest repelignita etus simin nonseque sundae idelit, volo bea dolupis dio to dite num labHarum iliquae pa cum ipide si diore sunt, omnis illab inimus. Tempore volut ulpa voluptaspis re desciae reperum doluptur, omnis dundae qui core, solorem olorro berspel iquibus pra nullaci aerferorpos et facearchic temporit, vel illenihit, arum il ium estibus aborepe lluptate velit laut untiundent optam quibus, sam quate volore</p>',
                    ],
                ]
            ],
        ];

        foreach ($pages as $page) {
            $createdAt = $updatedAt = date('Y-m-d H:i:s');
            $this->addSql("insert into contents values({$page['id']}, {$page['parent_id']}, '{$page['name']}', '{$page['level']}', '{$createdAt}', '{$updatedAt}', 'page')");
            $this->addSql("insert into contents_pages values({$page['id']}, '{$page['change_frequency']}', '{$page['route']}', {$page['priority']}, {$page['has_meta_title']}, {$page['has_meta_keywords']}, {$page['has_meta_description']}, {$page['has_content']}, '{$page['controller_action']}', '{$page['template']}')");
            foreach ($page['translations'] as $locale => $pageTranslation) {
                $this->addSql("insert into contents_pages_translations values(null, {$page['id']}, '{$pageTranslation['url']}', '{$pageTranslation['meta_title']}', '{$pageTranslation['meta_keywords']}', '{$pageTranslation['meta_description']}', '{$pageTranslation['content']}', '{$locale}')");
            }
        }

        foreach ($textConents as $textConent) {
            $createdAt = $updatedAt = date('Y-m-d H:i:s');
            $this->addSql("insert into contents values({$textConent['id']}, {$textConent['parent_id']}, '{$textConent['name']}', '{$textConent['level']}', '{$createdAt}', '{$updatedAt}', 'text_block')");
            $this->addSql("insert into contents_text_blocks values({$textConent['id']}, '{$textConent['uid']}', {$textConent['has_title']}, {$textConent['has_content']})");
            foreach ($textConent['translations'] as $locale => $textConentTranslation) {
                $this->addSql("insert into contents_text_blocks_translations values(null, {$textConent['id']}, '{$textConentTranslation['content']}', '{$locale}', '{$textConentTranslation['title']}')");
            }
        }
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DELETE FROM contents');
    }
}
