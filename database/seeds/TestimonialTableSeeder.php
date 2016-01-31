<?php

use App\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 20; $i++)
        {
            Testimonial::create([
                'user_id'   => rand(1, 72),
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi doloremque ea eaque facilis saepe! Consequatur cumque ducimus eum fugit ipsa iure, minus modi nam nesciunt odio perspiciatis, quasi qui quisquam ratione sunt tempore veniam. Aperiam illum iusto minus modi odit! Deleniti, id magni molestias nobis officia possimus quisquam? Optio praesentium provident tempora veritatis! Animi aspernatur atque beatae commodi corporis delectus deserunt dolore dolorem ea eligendi enim error illo, illum ipsum iure iusto labore laboriosam minima minus molestiae nobis non officiis optio possimus quidem quo reiciendis repellat similique vero voluptates. Deleniti dolore inventore laudantium maiores odio porro quas quo veniam voluptate?',
            ]);
        }
    }
}
