<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Customer;
use Faker\Factory as Faker;
use App\Models\ContractType;
use App\Models\Product;
use App\Models\Quote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fake = Faker::create();
        $projects = Project::get()->toArray();
        $users = User::pluck('id')->toArray();
        $types = ContractType::pluck('id')->toArray();
        for ($i = 0; $i < 250; $i++) {
            try {
                //code...

                $project = $projects[array_rand($projects)];
                DB::table('quotes')->insert([
                    [
                        'code' => $fake->ean8(),
                        'title' => $fake->realText($maxNbChars = 50, $indexSize = 2),
                        'contract_type_id' => $types[array_rand($types)],
                        'project_id' => $project['id'],
                        'customer_id' => $project['customer_id'],
                        'approve_id' => $users[array_rand($users)],
                        'quote_date' => $fake->date($format = 'Y-m-d', $max = 'now'),
                        'receiver' => $fake->name(),
                        'email' => $fake->freeEmail(),
                        'phone' => $fake->phoneNumber(),
                        'note' => $fake->realText($maxNbChars = 100, $indexSize = 2),
                        'created_by' => $users[array_rand($users)],
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime(),
                    ]
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        $quotes = Quote::all();
        $products = Product::get()->toArray();
        foreach ($quotes as $quote) {
            $total = 0;
            for ($i = 0; $i < 10; $i++) {
                try {
                    $product = $products[array_rand($products)];
                    $quantity = rand(1, 10);
                    DB::table('quote_products')->insert([
                        [
                            'quote_id' => $quote->id,
                            'product_id' => $product['id'],
                            'price' => $product['price'],
                            'quantity' => $quantity,
                            'amount' => $quantity * $product['price'],
                            'tax_rate' => 10,
                            'fee_rate' => 10,
                            'created_by' => $users[array_rand($users)],
                            'created_at' => new \DateTime(),
                            'updated_at' => new \DateTime(),
                        ]
                    ]);
                    $total += $quantity * $product['price'];
                    //code...
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            $quote->total_amount = $total;
            $quote->save();
        }
    }
}
