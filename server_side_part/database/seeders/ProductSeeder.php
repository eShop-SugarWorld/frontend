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
        $this->createProduct('American pie', 'Common American apple pie.', 12.50, 'Biscuits', ['flour', 'milk', 'apple'], 'american-pie.jpg');

        $this->createProduct('Grannys pies', 'Common Grannys pie.', 10.50, 'Biscuits', ['flour', 'milk', 'strawberry'], 'granny-pie.jpg');


        // Продукт "Chocolate pie"
        $this->createProduct('Chocolate pie', 'Delicious chocolate pie.', 15.00, 'Chocolate', ['flour', 'chocolate', 'sugar'], 'biscuits.jpg'); // Використовуємо те саме зображення
        // Продукт "Marmalade pie"
        $this->createProduct('Marmalade pie', 'Sweet marmalade pie.', 14.00, 'Marmalade', ['flour', 'marmalade', 'sugar'], 'granny-pie.jpg'); // Використовуємо те саме зображення
        // Продукт "Biscuits pie"
        $this->createProduct('Biscuits pie', 'Crispy biscuits pie.', 9.50, 'Biscuits', ['flour', 'butter', 'sugar'], 'biscuits-christmas.jpg'); // Використовуємо те саме зображення
        // Продукт "Date pie"
        $this->createProduct('Date pie', 'Tasty date pie.', 13.00, 'Date', ['flour', 'milk', 'sugar'], 'biscuits.jpg'); // Використовуємо те саме зображення
        // Продукт "Wedding cake"
        $this->createProduct('Wedding cake', 'Elegant wedding cake.', 50.00, 'Wedding', ['flour', 'butter', 'sugar'], 'american-pie.jpg'); // Використовуємо те саме зображення
        // Продукт "Birthday cake"
        $this->createProduct('Birthday cake', 'Colorful birthday cake.', 25.00, 'Birthday party', ['flour', 'butter', 'sugar', 'milk'], 'biscuits-christmas.jpg'); // Використовуємо те саме зображення
        $this->createProduct(
            'Mixed Pie',
            'Delicious mixed pie with various ingredients.',
            18.50,
            ['Biscuits', 'Wedding'],  // Додаємо обидві категорії
            ['flour', 'butter', 'sugar'],
            'american-pie.jpg'  // Використовуємо те саме зображення
        );
    }

    private function createProduct($name, $description, $price, $categoryNames, $ingredients, $imageFilename)
    {
        // Створення продукту
        $product = Product::create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
        ]);

//        // Створення категорії і додавання до продукту
//        $category = Category::firstOrCreate(['name' => $categoryName]);
//        $product->categories()->attach($category);
        if (!is_array($categoryNames)) {
            $categoryNames = [$categoryNames];
        }
        foreach ($categoryNames as $categoryName) {
            $category = Category::firstOrCreate(['name' => $categoryName]);
            $product->categories()->attach($category->id);
        }

        // Додавання інгредієнтів до продукту
        foreach ($ingredients as $ingredientName) {
            $ingredient = Ingredient::firstOrCreate(['name' => $ingredientName]);
            $product->ingredients()->attach($ingredient->id);
        }

        // Шлях до зображення
        $imagePath = public_path('images/' . $imageFilename);

        // Перевірка, чи існує файл
        if (File::exists($imagePath)) {
            echo "❌ ❌ ❌Зображення знайдено: $imagePath\n";
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




