<?php

use App\Shop\OrderStatuses\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    public function run()
    {
        factory(OrderStatus::class)->create([
            'name' => 'Pago',
            'color' => 'green'
        ]);

        factory(OrderStatus::class)->create([
            'name' => 'Pendete',
            'color' => 'yellow'
        ]);

        factory(OrderStatus::class)->create([
            'name' => 'Erro',
            'color' => 'red'
        ]);

        factory(OrderStatus::class)->create([
            'name' => 'Entregue',
            'color' => 'blue'
        ]);

        factory(OrderStatus::class)->create([
            'name' => 'Pedito Feito',
            'color' => 'violet'
        ]);

        factory(OrderStatus::class)->create([
            'name' => 'Mercado Pago',
            'color' => 'brown'
        ]);

        factory(OrderStatus::class)->create([
            'name' => 'Boleto Whatsapp',
            'color' => 'purple'
        ]);
    }
}