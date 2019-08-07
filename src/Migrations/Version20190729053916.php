<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190729053916 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $textConents = [
            'homepage_business_processing_carousel_6' => [
                'id' => 26,
                'parent_id' => 15,
                'name' => '6. Curabitur arcu erat, accumsan id imperdiet et.',
                'level' => 3,

                'uid' => 'homepage_business_processing_carousel_6',
                'has_title' => 1,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => '6. Curabitur arcu erat, accumsan id imperdiet et.',
                        'content' => '',
                    ],
                    'de' => [
                        'title' => '6. Curabitur arcu erat, accumsan id imperdiet et.',
                        'content' => '',
                    ],
                ]
            ],

            'homepage_business_processing_carousel_7' => [
                'id' => 27,
                'parent_id' => 15,
                'name' => '7. Curabitur arcu erat, accumsan id imperdiet et.',
                'level' => 3,

                'uid' => 'homepage_business_processing_carousel_7',
                'has_title' => 1,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => '7. Curabitur arcu erat, accumsan id imperdiet et.',
                        'content' => '',
                    ],
                    'de' => [
                        'title' => '7. Curabitur arcu erat, accumsan id imperdiet et.',
                        'content' => '',
                    ],
                ]
            ],

            'homepage_contact_form' => [
                'id' => 28,
                'parent_id' => 15,
                'name' => 'Contact form',
                'level' => 2,

                'uid' => 'homepage_contact_form',
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
                ],
            ],

            'homepage_contact_form_agree_label' => [
                'id' => 29,
                'parent_id' => 28,
                'name' => 'Agree label',
                'level' => 3,

                'uid' => 'homepage_contact_form_agree_label',
                'has_title' => 0,
                'has_content' => 1,

                'translations' => [
                    'en' => [
                        'title' => '',
                        'content' => '<p>I agree with <a href="%privacy_link%" target="_blank" style="color: #ffffff; text-decoration: underline">Privacy Policy</a></p>',
                    ],
                    'de' => [
                        'title' => '',
                        'content' => '<p>I agree with <a href="%privacy_link%" target="_blank" style="color: #ffffff; text-decoration: underline">Privacy Policy</a></p>',
                    ],
                ]
            ],

        ];

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

        $this->addSql('DELETE FROM contents where id in (26, 27, 28, 29)');
    }

}
