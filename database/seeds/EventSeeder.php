<?php

use App\Event;
use App\Ticket;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Stripe\StripeClient;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 2; $i++) {
            // Generate a start date between now and 1 month in the future
            $startDate = $faker->dateTimeBetween('now', '+1 month');

            // Generate an end date between the start date and 1 week in the future
            $endDate = $faker->dateTimeBetween($startDate, '+1 month');

            while ($startDate >= $endDate) {
                $endDate = $faker->dateTimeBetween($startDate, '+1 month');
            }

            $banner1 = $faker->imageUrl(640, 480); // Generate a random image URL
            $banner2 = $faker->imageUrl(640, 480); // Generate a random image URL

            $ageRestrictions = $faker->randomElement(['Minimum Age', 'Maximum Age', 'None']);
            $minAge = null;
            $maxAge = null;
            if ($ageRestrictions === 'Minimum Age') {
                $minAge = $faker->numberBetween(0, 100);
            } elseif ($ageRestrictions === 'Maximum Age') {
                $maxAge = $faker->numberBetween(0, 100);
            }

            $event = Event::create([
                'organizer_id' => 2,
                'title' => $faker->sentence(),
                'short_description' => $faker->text(100),
                'start_date' => $startDate,
                'start_time' => $faker->time(),
                'end_date' => $endDate,
                'end_time' => $faker->time(),
                'city_id' => $faker->numberBetween(1, 10),
                'category_id' => $faker->numberBetween(1, 10),
                'long_description' => $faker->text(),
                'terms_and_conditions' => $faker->text(),
                'age_restrictions' => $ageRestrictions,
                'min_age' => $minAge,
                'max_age' => $maxAge,
                'additional_info' => $faker->text(),
                'image1' => $banner1,
                'image2' => $banner2,
                'status' => 'Published',
                'booking_deadline' => $faker->dateTimeBetween($endDate, strtotime('+1 month'))
            ]);


            $stripe = new StripeClient(config('stripe.api_keys.secret_key'));

            for ($j = 0; $j < 1; $j++) {

                $ticketName = $faker->word();
                $price = $faker->randomFloat(2, 0, 100);
                // Convert the price to cents
                $price_in_cents = (int)($price * 100);

                $productObj = $stripe->products->create(['name' => $ticketName]);
                $priceObj = $stripe->prices->create([
                    'currency' => 'GBP',
                    'unit_amount' => $price_in_cents,
                    'product' => $productObj->id
                ]);
                Ticket::create([
                    'event_id' => $event->id,
                    'name' => $ticketName,
                    'description' => $faker->text(50),
                    'price' => $price,
                    'quantity' => $faker->numberBetween(0, 100),
                    'stripe_product_id' => $productObj->id,
                    'stripe_price_id' => $priceObj->id
                ]);
            }
        }
    }
}
