<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();

        try {
            if (DB::table('user_auth')->where('email', 'admin@gmail.com')->exists()) {
                DB::commit();
                return;
            }

            $userId = DB::table('user_info')->insertGetId([
                'first_name' => 'Admin',
                'last_name' => 'User',
                'phone_number' => '123456789',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('user_auth')->insert([
                'user_id' => $userId,
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception("Chyba pri vytváraní administrátora: " . $e->getMessage());
        }
       $this->createProduct('Choco Chunk Classics', 'Crunchy chocolate cookies loaded with gooey milk chocolate chunks.', 8.50, 'Biscuits', ['flour', 'milk chocolate', 'sugar', 'butter'], ['cookies1.jpg', 'cookies1.2.jpg']);

       $this->createProduct('Dark Cocoa Crispies', 'Deeply rich chocolate cookies with a crisp edge and a hint of sea salt.', 9.00, ['Biscuits', 'Birthday party'], ['flour', 'dark chocolate', 'cocoa powder', 'sea salt'], ['cookies2.jpg', 'cookies2.2.jpg']);

       $this->createProduct('Nutty Choco Rounds', 'Chewy chocolate cookies studded with roasted almonds and chocolate chips.', 10.00, 'Biscuits', ['flour', 'chocolate chips', 'almonds', 'brown sugar'], ['cookies3.jpg', 'cookies3.2.jpg']);

       $this->createProduct('Espresso Choco Bites', 'Bold chocolate cookies infused with espresso for a mocha-inspired delight.', 11.00, ['Biscuits', 'Birthday party'], ['flour', 'chocolate', 'espresso powder', 'sugar'], ['cookies4.jpg', 'cookies4.2.jpg']);

       $this->createProduct('Choco Cream Pockets', 'Soft chocolate cookies with a luscious dark chocolate ganache filling.', 15.00, ['Biscuits', 'Birthday party'], ['flour', 'cocoa powder', 'dark chocolate', 'cream'], ['biscuits1.jpg', 'biscuits1.2.jpg']);

        $this->createProduct('Marmalade Choco Rounds', 'Round chocolate cookies with a sweet, tangy marmalade center.', 20.00, ['Marmalade', 'Wedding'], ['flour', 'chocolate', 'marmalade', 'sugar'],['marmalade1.jpg', 'marmalade1.2.jpg']);



        $this->createProduct(
            'Velvet Berry Bliss',
            'A luxurious red velvet cake layered with creamy mascarpone and topped with a vibrant berry medley.',
            25.00,
            ['Date', 'Birthday party'],
            ['flour', 'cocoa powder', 'mascarpone', 'berries', 'sugar'],
            ['cake1.jpg', 'cake1.2.jpg']
        );

        $this->createProduct(
            'Choco Lava Majesty',
            'Rich chocolate sponge cake with a molten chocolate center that flows with every slice.',
            30.00,
            ['Date', 'Birthday party'],
            ['flour', 'dark chocolate', 'eggs', 'butter', 'sugar'],
            ['cake2.jpg', 'cake2.2.jpg']
        );

        $this->createProduct(
            'Coconut Dream Cloud',
            'Light and fluffy coconut cake layered with whipped cream and toasted coconut flakes.',
            28.00,
            ['Date', 'Birthday party'],
            ['flour', 'coconut milk', 'eggs', 'whipping cream', 'sugar'],
            ['cake3.jpg', 'cake3.2.jpg']
        );

        $this->createProduct(
            'Zesty Lemon Opera',
            'A delicate lemon sponge cake layered with tangy curd and silky lemon buttercream.',
            26.00,
            ['Wedding', 'Birthday party'],
            ['flour', 'lemon zest', 'eggs', 'butter', 'sugar'],
            ['cake4.jpg', 'cake4.2.jpg']
        );

        $this->createProduct(
            'Caramel Crunch Tower',
            'Multi-layered caramel cake with crunchy praline layers and a salted caramel drizzle.',
            32.00,
            ['Wedding', 'Birthday party'],
            ['flour', 'caramel', 'praline', 'butter', 'sugar'],
            ['cake5.jpg', 'cake5.2.jpg']
        );



        $this->createProduct(
            'Berry Choco Symphony',
            'A rich dark chocolate bar harmonized with bursts of dried strawberries, raspberries, and blueberries.',
            12.00,
            ['Chocolate', 'Wedding'],
            ['dark chocolate', 'dried strawberries', 'dried raspberries', 'dried blueberries'],
            ['chocolate2.jpg', 'chocolate2.2.jpg']
        );

        $this->createProduct(
            'Ruby Crunch Delight',
            'Silky ruby chocolate embedded with crunchy cranberry pieces and a hint of vanilla.',
            14.00,
            ['Chocolate', 'Date'],
            ['ruby chocolate', 'cranberries', 'vanilla', 'cocoa butter'],
            ['chocolate3.jpg', 'chocolate3.2.jpg']
        );




        $this->createProduct(
            'Fruit Jewel Glaze Cake',
            'A light sponge base topped with layers of silky cream and a vibrant mosaic of fruit suspended in shimmering berry jelly.',
            22.00,
            ['Marmalade', 'Birthday party'],
            ['flour', 'cream', 'gelatin', 'strawberries', 'kiwi', 'blueberries', 'sugar'],
            ['marmalade2.jpg', 'marmalade2.2.jpg']
        );



        // Продукт "Birthday cake"
//        $this->createProduct('Birthday cake', 'Colorful birthday cake.', 25.00, 'Birthday party', ['flour', 'butter', 'sugar', 'milk'], ['biscuits-christmas.jpg', 'biscuits.jpg']);
//
//        $this->createProduct(
//            'Mixed Pie',
//            'Delicious mixed pie with various ingredients.',
//            18.50,
//            ['Biscuits', 'Wedding'],
//            ['flour', 'butter', 'sugar'],
//            ['american-pie.jpg', 'granny-pie.jpg']
//        );
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
                echo "✔️ Image found: $imagePath\n";
                $imageData = file_get_contents($imagePath);

                $image = new Image([
                    'product_id' => $product->id,
                    'image_data' => base64_encode($imageData),
                ]);

                try {
                    if ($image->save()) {
                        echo "✔️ Image successfully added to the product.\n";
                    } else {
                        echo "❌ Error while adding the image to the database.\n";
                    }
                } catch (\Exception $e) {
                    echo "❌ Exception while saving the image: " . $e->getMessage() . "\n";
                }
            } else {
                echo "❌ Image not found: $imagePath\n";
            }
        }
    }
}
