<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

/**
 * Класс для тестирования обмена с 1С
 */
class OneCExchengeTest extends TestCase
{
    /**
     * Проверяет наличие пользователя для обмена с 1С
     *
     * @return void
     */
    public function testUserExists(): void
    {
        $this->assertDatabaseHas('users', [
            'email' => env('ONE_C_EMAIL')
        ]);
    }

    /**
     * Тестирование авторизации для обмена с 1С
     *
     * @return void
     */
    public function testAuth()
    {
        $response = $this->get(
            route('1sProtocolCatalog', [
                'type' => 'catalog',
                'mode' => 'checkauth',
            ]),
            [
                'Authorization' => 'Basic ' . base64_encode(env('ONE_C_EMAIL'). ":" . env('ONE_C_PASSWORD'))
            ]
        );

        $content = $response->content();
        $arRows = explode("\n", $content);

        $this->assertTrue($arRows[0] == "success");

        $response->assertStatus(200);
    }

    /**
     * Тестирование импорта товаров
     *
     * @return void
     */
    public function testAttributesXmlParser()
    {

    }

    /**
     * Тестирование импорта товаров
     *
     * @return void
     */
    public function testImportProducts()
    {

    }

    /**
     * Тестирование импорта категорий
     *
     * @return void
     */
    public function testImportCategories()
    {

    }
}
