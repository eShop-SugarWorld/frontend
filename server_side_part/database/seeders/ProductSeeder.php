<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Image;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->createProduct('Choco Chunk Classics', 'Crunchy chocolate cookies loaded with gooey milk chocolate chunks.', 8.50, 'Biscuits', ['flour', 'milk chocolate', 'sugar', 'butter'], ['cookies1.jpg', 'cookies1.2.jpg']);

        $this->createProduct('Dark Cocoa Crispies', 'Deeply rich chocolate cookies with a crisp edge and a hint of sea salt.', 9.00, ['Biscuits', 'Birthday party'], ['flour', 'dark chocolate', 'cocoa powder', 'sea salt'], ['cookies2.jpg', 'cookies2.2.jpg']);
        
        $this->createProduct('Nutty Choco Rounds', 'Chewy chocolate cookies studded with roasted almonds and chocolate chips.', 10.00, 'Biscuits', ['flour', 'chocolate chips', 'almonds', 'brown sugar'], ['cookies3.jpg', 'cookies3.2.jpg']);
        
        $this->createProduct('Espresso Choco Bites', 'Bold chocolate cookies infused with espresso for a mocha-inspired delight.', 11.00, ['Biscuits', 'Birthday party'], ['flour', 'chocolate', 'espresso powder', 'sugar'], ['cookies4.jpg', 'cookies4.2.jpg']);

        $this->createProduct('Choco Cream Pockets', 'Soft chocolate cookies with a luscious dark chocolate ganache filling.', 15.00, ['Biscuits', 'Birthday party'], ['flour', 'cocoa powder', 'dark chocolate', 'cream'], ['biscuits5.jpg', 'bisquits5.2.jpg']);

        $this->createProduct('Marmalade Choco Rounds', 'Round chocolate cookies with a sweet, tangy marmalade center.', 20.00, ['Marmalade', 'Wedding'], ['flour', 'chocolate', 'marmalade', 'sugar'], ['marmalade1.jpg', '']);



        

        // Продукт "Birthday cake"
        $this->createProduct('Birthday cake', 'Colorful birthday cake.', 25.00, 'Birthday party', ['flour', 'butter', 'sugar', 'milk'], ['biscuits-christmas.jpg', 'biscuits.jpg']);

        $this->createProduct(
            'Mixed Pie',
            'Delicious mixed pie with various ingredients.',
            18.50,
            ['Biscuits', 'Wedding'],
            ['flour', 'butter', 'sugar'],
            ['american-pie.jpg', 'granny-pie.jpg']
        );
    }

    private function createProduct($name, $description, $price, $categoryNames, $ingredients, $imageFilenames)
    {
        // Створення продукту
        $product = Product::create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
        ]);

        // Додавання категорій
        if (!is_array($categoryNames)) {
            $categoryNames = [$categoryNames];
        }
        foreach ($categoryNames as $categoryName) {
            $category = Category::firstOrCreate(['name' => $categoryName]);
            $product->categories()->attach($category->id);
        }

        // Додавання інгредієнтів
        foreach ($ingredients as $ingredientName) {
            $ingredient = Ingredient::firstOrCreate(['name' => $ingredientName]);
            $product->ingredients()->attach($ingredient->id);
        }

        // Додавання двох зображень
        foreach ($imageFilenames as $imageFilename) {
            $imagePath = public_path('images/' . $imageFilename);

            if (File::exists($imagePath)) {
                echo "✔️ Зображення знайдено: $imagePath\n";
                $imageData = file_get_contents($imagePath);

                $image = new Image([
                    'product_id' => $product->id,
                    'image_data' => base64_encode($imageData),
                ]);

                try {
                    if ($image->save()) {
                        echo "✔️ Зображення успішно додано до продукту.\n";
                    } else {
                        echo "❌ Помилка при додаванні зображення до бази даних.\n";
                    }
                } catch (\Exception $e) {
                    echo "❌ Exception при збереженні зображення: " . $e->getMessage() . "\n";
                }
            } else {
                echo "❌ Зображення не знайдено: $imagePath\n";
            }
        }
    }
}