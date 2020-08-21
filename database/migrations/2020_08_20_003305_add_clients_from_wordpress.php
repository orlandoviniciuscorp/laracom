<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientsFromWordpress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::select('delete from addresses');
        DB::select('delete from customers');


        $usersWp = DB::select('select id, user_email,user_login from wpji_users');

        foreach($usersWp as $userWp){
            $customer = new \App\Shop\Customers\Customer();
            $customer->name = $userWp->user_login;
            $customer->email = $userWp->user_email;
            $customer->password = 'empyt-pass';
            $customer->save();

            //dump($userWp);

            $addressesCustomer = new \App\Shop\Addresses\Address();

            $addressesCustomer->customer_id = $customer->id;
            $addressesCustomer->country_id = 1;
            $addressesCustomer->status = 1;

            $userAddressWp = DB::select('select meta_key, meta_value ' .
                    ' from wpji_usermeta where user_id = ? ',[$userWp->id]);

            $addressesCustomer->alias = "Endereço 1";

            foreach($userAddressWp as $userAddressMeta){

              if($userAddressMeta->meta_key == 'billing_address_1'){
                  if($userAddressMeta->meta_value != "") {
                     // dump('Endereco_1  :'. $userAddressMeta->meta_value);
                      $addressesCustomer->address_1 = $userAddressMeta->meta_value;
                  }else{
                      $addressesCustomer->address_1   = "Não Encontrado";
                      break;
                  }
              }else if($userAddressMeta->meta_key == 'billing_address_2'){
                  $addressesCustomer->address_2 = $userAddressMeta->meta_value;
              }else if($userAddressMeta->meta_key == 'billing_phone' &&
                  $userAddressMeta->meta_value != ""){
                  $addressesCustomer->phone = $userAddressMeta->meta_value;
              }else if($userAddressMeta->meta_key == 'billing_cellphone' &&
                  $userAddressMeta->meta_value != ""){
                  $addressesCustomer->phone = $userAddressMeta->meta_value;
              }else if($userAddressMeta->meta_key == 'billing_postcode' &&
                  $userAddressMeta->meta_value != ""){
                  $addressesCustomer->zip = $userAddressMeta->meta_value;
              }else if($userAddressMeta->meta_key == 'shipping_city' &&
                  $userAddressMeta->meta_value != ""){
                  $addressesCustomer->city = $userAddressMeta->meta_value;
              }else if($userAddressMeta->meta_key == 'billing_neighborhood'){
                  if($userAddressMeta->meta_value != "") {
                      $addressesCustomer->neighborhoods = $userAddressMeta->meta_value;
                  }else{
                      $addressesCustomer->neighborhoods = 'Não Encontrado';
                  }
              }
            }
            if($addressesCustomer->address_1   != "Não Encontrado" &&
                !is_null($addressesCustomer->address_1) ) {

                $addressesCustomer->save();
            }else{
                dump($customer->name . ' Endereço não cadastrado');
            }
            //dump($addressesCustomer);




        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::select('delete from addresses');
        DB::select('delete from customers');
        //app(\App\Shop\Customers\Customer::class)->truncate();
    }
}
