<?php

namespace Module\Inventory\Seeders;


use Module\Inventory\Models\Product;
use Module\Inventory\Models\Category;
use Module\Inventory\Models\SubCategory;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boricAcid = SubCategory::where('slug', 'boric-acid')->first();
        $humicGoldPlus = SubCategory::where('slug', 'humic-gold-plus')->first();
        $bongoMag = SubCategory::where('slug', 'bongo-mag')->first();
        $rootGrow = SubCategory::where('slug', 'root-grow')->first();
        $soluborBoron = SubCategory::where('slug', 'solubor-boron')->first();
        $bongoZinc = SubCategory::where('slug', 'bongo-zinc')->first();
        $zypsum = SubCategory::where('slug', 'zypsum')->first();
        $sakuraGold = SubCategory::where('slug', 'sakura-gold')->first();
        $tonic = SubCategory::where('slug', 'tonic')->first();
        $bongoShot = SubCategory::where('slug', 'bongo-shot')->first();
        $cipro = SubCategory::where('slug', 'cipro')->first();
        $imo = SubCategory::where('slug', 'imo')->first();
        $karmo = SubCategory::where('slug', 'karmo')->first();
        $mestra = SubCategory::where('slug', 'mestra')->first();
        $pairaits = SubCategory::where('slug', 'pairaits')->first();
        $rafyel = SubCategory::where('slug', 'rafyel')->first();
        $strip = SubCategory::where('slug', 'strip')->first();
        $bitterGourd = SubCategory::where('slug', 'bitter-gourd')->first();
        $okra = SubCategory::where('slug', 'okra')->first();
        $bottleGourd = SubCategory::where('slug', 'bottle-gourd')->first();
        $chili = SubCategory::where('slug', 'chili')->first();
        $pumpkin = SubCategory::where('slug', 'pumpkin')->first();
        $cucumber = SubCategory::where('slug', 'cucumber')->first();
        $snackGourd = SubCategory::where('slug', 'snack-gourd')->first();
        $ridgeGourd = SubCategory::where('slug', 'ridge-gourd')->first();
        $spongeGourd = SubCategory::where('slug', 'sponge-gourd')->first();
        $watermealon = SubCategory::where('slug', 'watermealon')->first();
        $brinjal = SubCategory::where('slug', 'brinjal')->first();
        $radish = SubCategory::where('slug', 'radish')->first();
        $knolkhol = SubCategory::where('slug', 'knolkhol')->first();
        $tometo = SubCategory::where('slug', 'tometo')->first();
        $cauliflower = SubCategory::where('slug', 'cauliflower')->first();
        
        $products = [
            [
                'category_id' => $boricAcid->category_id,
                'sub_category_id' => $boricAcid->id,
                'title' => 'Bongo Boric (Boric Acid) 500gm',
            ],
            [
                'category_id' => $humicGoldPlus->category_id,
                'sub_category_id' => $humicGoldPlus->id,
                'title' => 'Bongo Humic Gold Plus 500gm',
            ],
            [
                'category_id' => $bongoMag->category_id,
                'sub_category_id' => $bongoMag->id,
                'title' => 'Bongo Mag (Crystal) 1kg',
            ],
            [
                'category_id' => $bongoMag->category_id,
                'sub_category_id' => $bongoMag->id,
                'title' => 'Bongo Mag (Dust) 1kg',
            ],
            [
                'category_id' => $rootGrow->category_id,
                'sub_category_id' => $rootGrow->id,
                'title' => 'Bongo Root Grow (NAA) 1kg',
            ],
            [
                'category_id' => $soluborBoron->category_id,
                'sub_category_id' => $soluborBoron->id,
                'title' => 'Bongo Solubor (Solubor Boron) 100gm',
            ],
            [
                'category_id' => $soluborBoron->category_id,
                'sub_category_id' => $soluborBoron->id,
                'title' => 'Bongo Solubor (Solubor Boron) 500gm',
            ],
            [
                'category_id' => $bongoZinc->category_id,
                'sub_category_id' => $bongoZinc->id,
                'title' => 'Bongo Zinc (Chelated) 17gm',
            ],
            [
                'category_id' => $bongoZinc->category_id,
                'sub_category_id' => $bongoZinc->id,
                'title' => 'Bongo Zinc (Hepta) 1kg',
            ],
            [
                'category_id' => $bongoZinc->category_id,
                'sub_category_id' => $bongoZinc->id,
                'title' => 'Bongo Zinc (Mono) 1kg',
            ],
            [
                'category_id' => $zypsum->category_id,
                'sub_category_id' => $zypsum->id,
                'title' => 'Bongo Zypsum 10kg',
            ],
            [
                'category_id' => $zypsum->category_id,
                'sub_category_id' => $zypsum->id,
                'title' => 'Bongo Zypsum 5kg',
            ],
            [
                'category_id' => $sakuraGold->category_id,
                'sub_category_id' => $sakuraGold->id,
                'title' => 'Sakura Gold (PGR) 1000ml',
            ],
            [
                'category_id' => $sakuraGold->category_id,
                'sub_category_id' => $sakuraGold->id,
                'title' => 'Sakura Gold (PGR) 100ml',
            ],
            [
                'category_id' => $sakuraGold->category_id,
                'sub_category_id' => $sakuraGold->id,
                'title' => 'Sakura Gold (PGR) 250ml',
            ],
            [
                'category_id' => $sakuraGold->category_id,
                'sub_category_id' => $sakuraGold->id,
                'title' => 'Sakura Gold (PGR) 500ml',
            ],
            [
                'category_id' => $tonic->category_id,
                'sub_category_id' => $tonic->id,
                'title' => 'Tonic (GA-3) 10gm',
            ],
            [
                'category_id' => $bongoShot->category_id,
                'sub_category_id' => $bongoShot->id,
                'title' => 'Bongo Shot 20 EC 100ml',
            ],
            [
                'category_id' => $bongoShot->category_id,
                'sub_category_id' => $bongoShot->id,
                'title' => 'Bongo Shot 20 EC 400ml',
            ],
            [
                'category_id' => $bongoShot->category_id,
                'sub_category_id' => $bongoShot->id,
                'title' => 'Bongo Shot 20 EC 50ml',
            ],
            [
                'category_id' => $cipro->category_id,
                'sub_category_id' => $cipro->id,
                'title' => 'Cipro 55 EC 1000ml',
            ],
            [
                'category_id' => $cipro->category_id,
                'sub_category_id' => $cipro->id,
                'title' => 'Cipro 55 EC 100ml',
            ],
            [
                'category_id' => $cipro->category_id,
                'sub_category_id' => $cipro->id,
                'title' => 'Cipro 55 EC 400ml',
            ],
            [
                'category_id' => $cipro->category_id,
                'sub_category_id' => $cipro->id,
                'title' => 'Cipro 55 EC 500ml',
            ],
            [
                'category_id' => $cipro->category_id,
                'sub_category_id' => $cipro->id,
                'title' => 'Cipro 55 EC 50ml',
            ],
            [
                'category_id' => $imo->category_id,
                'sub_category_id' => $imo->id,
                'title' => 'IMO 60 WDG 100gm',
            ],
            [
                'category_id' => $imo->category_id,
                'sub_category_id' => $imo->id,
                'title' => 'IMO 60 WDG 50gm',
            ],
            [
                'category_id' => $imo->category_id,
                'sub_category_id' => $imo->id,
                'title' => 'IMO WDG 300gm',
            ],
            [
                'category_id' => $karmo->category_id,
                'sub_category_id' => $karmo->id,
                'title' => 'Karmo 75 WP 100gm',
            ],
            [
                'category_id' => $karmo->category_id,
                'sub_category_id' => $karmo->id,
                'title' => 'Karmo 75 WP 500gm',
            ],
            [
                'category_id' => $mestra->category_id,
                'sub_category_id' => $mestra->id,
                'title' => 'Mestra 55 SC 100ml',
            ],
            [
                'category_id' => $mestra->category_id,
                'sub_category_id' => $mestra->id,
                'title' => 'Mestra 55 SC 250ml',
            ],
            [
                'category_id' => $mestra->category_id,
                'sub_category_id' => $mestra->id,
                'title' => 'Mestra 55 SC 500ml',
            ],
            [
                'category_id' => $pairaits->category_id,
                'sub_category_id' => $pairaits->id,
                'title' => 'Pairaits 70 WG 100gm',
            ],
            [
                'category_id' => $pairaits->category_id,
                'sub_category_id' => $pairaits->id,
                'title' => 'Pairaits 70 WG 15gm',
            ],
            [
                'category_id' => $pairaits->category_id,
                'sub_category_id' => $pairaits->id,
                'title' => 'Pairaits 70 WG 50gm',
            ],
            [
                'category_id' => $rafyel->category_id,
                'sub_category_id' => $rafyel->id,
                'title' => 'Rafayel 18 WP 100gm',
            ],
            [
                'category_id' => $strip->category_id,
                'sub_category_id' => $strip->id,
                'title' => 'Strip 100ml',
            ],
            [
                'category_id' => $strip->category_id,
                'sub_category_id' => $strip->id,
                'title' => 'Strip 400ml',
            ],
            [
                'category_id' => $strip->category_id,
                'sub_category_id' => $strip->id,
                'title' => 'Strip 500ml',
            ],
            [
                'category_id' => $strip->category_id,
                'sub_category_id' => $strip->id,
                'title' => 'Strip SC 50ml',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Kaveri-88 10gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Captain 10gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Utshob 10gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Utshob 20gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Jhumka Super 10gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Maharaza Plus 10gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Samira Plus 10gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Hasi 10gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Hasi 20gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Shokh 10gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Shokh 20gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Kajol Super 10gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Jui 10gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Jui 20gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Bongo Queen 5gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Bongo Queen 10gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Chamok 10gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Khushi 10gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Khushi 20gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Bongo King 5gm',
            ],
            [
                'category_id' => $bitterGourd->category_id,
                'sub_category_id' => $bitterGourd->id,
                'title' => 'Bongo King 10gm',
            ],
            [
                'category_id' => $okra->category_id,
                'sub_category_id' => $okra->id,
                'title' => 'Punam 50gm',
            ],
            [
                'category_id' => $okra->category_id,
                'sub_category_id' => $okra->id,
                'title' => 'Priya 10gm',
            ],
            [
                'category_id' => $okra->category_id,
                'sub_category_id' => $okra->id,
                'title' => 'Priya 25gm',
            ],
            [
                'category_id' => $okra->category_id,
                'sub_category_id' => $okra->id,
                'title' => 'Priya 50gm',
            ],
            [
                'category_id' => $okra->category_id,
                'sub_category_id' => $okra->id,
                'title' => 'Priya 100gm',
            ],
            [
                'category_id' => $okra->category_id,
                'sub_category_id' => $okra->id,
                'title' => 'Laboni 50gm',
            ],
            [
                'category_id' => $okra->category_id,
                'sub_category_id' => $okra->id,
                'title' => 'Laboni 100gm',
            ],
            [
                'category_id' => $okra->category_id,
                'sub_category_id' => $okra->id,
                'title' => 'Boishakhi 50gm',
            ],
            [
                'category_id' => $okra->category_id,
                'sub_category_id' => $okra->id,
                'title' => 'Boishakhi 100gm',
            ],
            [
                'category_id' => $okra->category_id,
                'sub_category_id' => $okra->id,
                'title' => 'Bharat 100gm',
            ],
            [
                'category_id' => $bottleGourd->category_id,
                'sub_category_id' => $bottleGourd->id,
                'title' => 'Ovi 10gm',
            ],
            [
                'category_id' => $bottleGourd->category_id,
                'sub_category_id' => $bottleGourd->id,
                'title' => 'Rosia 5gm',
            ],
            [
                'category_id' => $bottleGourd->category_id,
                'sub_category_id' => $bottleGourd->id,
                'title' => 'Rosia 10gm',
            ],
            [
                'category_id' => $bottleGourd->category_id,
                'sub_category_id' => $bottleGourd->id,
                'title' => 'Mayuri 5gm',
            ],
            [
                'category_id' => $bottleGourd->category_id,
                'sub_category_id' => $bottleGourd->id,
                'title' => 'Mayuri 10gm',
            ],
            [
                'category_id' => $bottleGourd->category_id,
                'sub_category_id' => $bottleGourd->id,
                'title' => 'Bongo Super 5gm',
            ],
            [
                'category_id' => $bottleGourd->category_id,
                'sub_category_id' => $bottleGourd->id,
                'title' => 'Bongo Super 10gm',
            ],
            [
                'category_id' => $bottleGourd->category_id,
                'sub_category_id' => $bottleGourd->id,
                'title' => 'Bongo Gold 5gm',
            ],
            [
                'category_id' => $bottleGourd->category_id,
                'sub_category_id' => $bottleGourd->id,
                'title' => 'Bongo Gold 10gm',
            ],
            [
                'category_id' => $bottleGourd->category_id,
                'sub_category_id' => $bottleGourd->id,
                'title' => 'Deizi 5gm',
            ],
            [
                'category_id' => $bottleGourd->category_id,
                'sub_category_id' => $bottleGourd->id,
                'title' => 'Deizi 10gm',
            ],
            [
                'category_id' => $bottleGourd->category_id,
                'sub_category_id' => $bottleGourd->id,
                'title' => 'Super Green 5gm',
            ],
            [
                'category_id' => $bottleGourd->category_id,
                'sub_category_id' => $bottleGourd->id,
                'title' => 'Super Green 10gm',
            ],
            [
                'category_id' => $chili->category_id,
                'sub_category_id' => $chili->id,
                'title' => 'KHC-179 10gm',
            ],
            [
                'category_id' => $chili->category_id,
                'sub_category_id' => $chili->id,
                'title' => 'BS-1701 DG 5gm',
            ],
            [
                'category_id' => $chili->category_id,
                'sub_category_id' => $chili->id,
                'title' => 'BS-1701 DG 10gm',
            ],
            [
                'category_id' => $chili->category_id,
                'sub_category_id' => $chili->id,
                'title' => 'KHC-177 10gm',
            ],
            [
                'category_id' => $chili->category_id,
                'sub_category_id' => $chili->id,
                'title' => 'Lalgolapi 5gm',
            ],
            [
                'category_id' => $chili->category_id,
                'sub_category_id' => $chili->id,
                'title' => 'Lalgolapi 10gm',
            ],
            [
                'category_id' => $chili->category_id,
                'sub_category_id' => $chili->id,
                'title' => 'Boby 10gm',
            ],
            [
                'category_id' => $chili->category_id,
                'sub_category_id' => $chili->id,
                'title' => 'Fire Green 5gm',
            ],
            [
                'category_id' => $chili->category_id,
                'sub_category_id' => $chili->id,
                'title' => 'Fire Green 10gm',
            ],
            [
                'category_id' => $pumpkin->category_id,
                'sub_category_id' => $pumpkin->id,
                'title' => 'Sweet Star 5gm',
            ],
            [
                'category_id' => $pumpkin->category_id,
                'sub_category_id' => $pumpkin->id,
                'title' => 'Sweet Star 10gm',
            ],
            [
                'category_id' => $pumpkin->category_id,
                'sub_category_id' => $pumpkin->id,
                'title' => 'Chitra Sweet-2 5gm',
            ],
            [
                'category_id' => $pumpkin->category_id,
                'sub_category_id' => $pumpkin->id,
                'title' => 'Chitra Sweet-2 10gm',
            ],
            [
                'category_id' => $pumpkin->category_id,
                'sub_category_id' => $pumpkin->id,
                'title' => 'Royel Bangle 5gm',
            ],
            [
                'category_id' => $pumpkin->category_id,
                'sub_category_id' => $pumpkin->id,
                'title' => 'Royel Bangle 10gm',
            ],
            [
                'category_id' => $pumpkin->category_id,
                'sub_category_id' => $pumpkin->id,
                'title' => 'Sweet Plus 5gm',
            ],
            [
                'category_id' => $pumpkin->category_id,
                'sub_category_id' => $pumpkin->id,
                'title' => 'Sweet Plus 10gm',
            ],
            [
                'category_id' => $pumpkin->category_id,
                'sub_category_id' => $pumpkin->id,
                'title' => 'Bongo Sweet 5gm',
            ],
            [
                'category_id' => $pumpkin->category_id,
                'sub_category_id' => $pumpkin->id,
                'title' => 'Bongo Sweet 10gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Deluxe-777 1gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Deluxe-777 5gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Deluxe-777 10gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Super King 10gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Juboraj 10gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Sabuj Shathi 5gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Sabuj Shathi 10gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Champion-1122 5gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Champion-1122 10gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'BS-1122 5gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'BS-1122 10gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Rajmoti 5gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Rajmoti 10gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Kiyara 10gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Bongo Green 5gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Bongo Green 10gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Excellent 5gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Excellent 10gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Anonna 5gm',
            ],
            [
                'category_id' => $cucumber->category_id,
                'sub_category_id' => $cucumber->id,
                'title' => 'Anonna 10gm',
            ],
            [
                'category_id' => $snackGourd->category_id,
                'sub_category_id' => $snackGourd->id,
                'title' => 'Bongo Rekha 5gm',
            ],
            [
                'category_id' => $snackGourd->category_id,
                'sub_category_id' => $snackGourd->id,
                'title' => 'Bongo Rekha 10gm',
            ],
            [
                'category_id' => $snackGourd->category_id,
                'sub_category_id' => $snackGourd->id,
                'title' => 'Varosha 5gm',
            ],
            [
                'category_id' => $snackGourd->category_id,
                'sub_category_id' => $snackGourd->id,
                'title' => 'Varosha 10gm',
            ],
            [
                'category_id' => $snackGourd->category_id,
                'sub_category_id' => $snackGourd->id,
                'title' => 'Bipasha 5gm',
            ],
            [
                'category_id' => $snackGourd->category_id,
                'sub_category_id' => $snackGourd->id,
                'title' => 'Bipasha 10gm',
            ],
            [
                'category_id' => $ridgeGourd->category_id,
                'sub_category_id' => $ridgeGourd->id,
                'title' => 'Super Shot 5gm',
            ],
            [
                'category_id' => $ridgeGourd->category_id,
                'sub_category_id' => $ridgeGourd->id,
                'title' => 'Super Shot 10gm',
            ],
            [
                'category_id' => $ridgeGourd->category_id,
                'sub_category_id' => $ridgeGourd->id,
                'title' => 'Green Shot 10gm',
            ],
            [
                'category_id' => $ridgeGourd->category_id,
                'sub_category_id' => $ridgeGourd->id,
                'title' => 'Sangram 5gm',
            ],
            [
                'category_id' => $ridgeGourd->category_id,
                'sub_category_id' => $ridgeGourd->id,
                'title' => 'Sangram 10gm',
            ],
            [
                'category_id' => $ridgeGourd->category_id,
                'sub_category_id' => $ridgeGourd->id,
                'title' => 'Green Star 5gm',
            ],
            [
                'category_id' => $ridgeGourd->category_id,
                'sub_category_id' => $ridgeGourd->id,
                'title' => 'Green Star 10gm',
            ],
            [
                'category_id' => $spongeGourd->category_id,
                'sub_category_id' => $spongeGourd->id,
                'title' => 'Mukti 5gm',
            ],
            [
                'category_id' => $spongeGourd->category_id,
                'sub_category_id' => $spongeGourd->id,
                'title' => 'Mukti 10gm',
            ],
            [
                'category_id' => $spongeGourd->category_id,
                'sub_category_id' => $spongeGourd->id,
                'title' => 'Mitaly 5gm',
            ],
            [
                'category_id' => $spongeGourd->category_id,
                'sub_category_id' => $spongeGourd->id,
                'title' => 'Mitaly 10gm',
            ],
            [
                'category_id' => $spongeGourd->category_id,
                'sub_category_id' => $spongeGourd->id,
                'title' => 'Aliya 10gm',
            ],
            [
                'category_id' => $watermealon->category_id,
                'sub_category_id' => $watermealon->id,
                'title' => 'Ullash 20gm',
            ],
            [
                'category_id' => $watermealon->category_id,
                'sub_category_id' => $watermealon->id,
                'title' => 'Ullash 50gm',
            ],
            [
                'category_id' => $watermealon->category_id,
                'sub_category_id' => $watermealon->id,
                'title' => 'Ullash 100gm',
            ],
            [
                'category_id' => $watermealon->category_id,
                'sub_category_id' => $watermealon->id,
                'title' => 'Top Dragon 100gm',
            ],
            [
                'category_id' => $watermealon->category_id,
                'sub_category_id' => $watermealon->id,
                'title' => 'Five Star Dragon 50gm',
            ],
            [
                'category_id' => $watermealon->category_id,
                'sub_category_id' => $watermealon->id,
                'title' => 'Five Star Dragon 100gm',
            ],
            [
                'category_id' => $watermealon->category_id,
                'sub_category_id' => $watermealon->id,
                'title' => 'Mithai 50gm',
            ],
            [
                'category_id' => $watermealon->category_id,
                'sub_category_id' => $watermealon->id,
                'title' => 'Mithai 100gm',
            ],
            [
                'category_id' => $watermealon->category_id,
                'sub_category_id' => $watermealon->id,
                'title' => 'Shahi 50gm',
            ],
            [
                'category_id' => $watermealon->category_id,
                'sub_category_id' => $watermealon->id,
                'title' => 'Shahi 100gm',
            ],
            [
                'category_id' => $brinjal->category_id,
                'sub_category_id' => $brinjal->id,
                'title' => 'KEP-1509 10gm',
            ],
            [
                'category_id' => $brinjal->category_id,
                'sub_category_id' => $brinjal->id,
                'title' => 'Bagun King 5gm',
            ],
            [
                'category_id' => $brinjal->category_id,
                'sub_category_id' => $brinjal->id,
                'title' => 'Bagun King 10gm',
            ],
            [
                'category_id' => $brinjal->category_id,
                'sub_category_id' => $brinjal->id,
                'title' => 'Aporupa 5gm',
            ],
            [
                'category_id' => $brinjal->category_id,
                'sub_category_id' => $brinjal->id,
                'title' => 'Aporupa 10gm',
            ],
            [
                'category_id' => $radish->category_id,
                'sub_category_id' => $radish->id,
                'title' => 'BS-305 100gm',
            ],
            [
                'category_id' => $knolkhol->category_id,
                'sub_category_id' => $knolkhol->id,
                'title' => 'Happy 10gm',
            ],
            [
                'category_id' => $tometo->category_id,
                'sub_category_id' => $tometo->id,
                'title' => 'Anjali 5gm',
            ],
            [
                'category_id' => $tometo->category_id,
                'sub_category_id' => $tometo->id,
                'title' => 'KTM-1405 5gm',
            ],
            [
                'category_id' => $cauliflower->category_id,
                'sub_category_id' => $cauliflower->id,
                'title' => 'White Express 10gm',
            ],
        ];

        foreach ($products as $product) {
            $category = Category::find($product['category_id']);
            $catPrefix = strtoupper(substr($category->name, 0, 1));

            $subCategory = SubCategory::find($product['sub_category_id']);
            $subWords = explode(' ', $subCategory->name);

            $subPrefix = '';
            foreach ($subWords as $word) {
                $subPrefix .= strtoupper(substr($word, 0, 1));
            }

            $randNum = mt_rand(1000, 9999);

            $sku = $catPrefix . $subPrefix . $randNum;
            
            Product::create([
                'category_id' => $product['category_id'],
                'sub_category_id' => $product['sub_category_id'],
                'title' => $product['title'],
                'slug' => Str::slug($product['title']),
                'sku' => $sku
            ]);
        }
    }
}
