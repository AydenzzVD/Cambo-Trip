<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\Place;
use App\Models\Tag;
use App\Models\Activity;
use App\Models\Food;
use App\Models\Hotel;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TravelDataSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('data.json');
        
        if (!File::exists($jsonPath)) {
            $this->command->error("data.json not found at {$jsonPath}!");
            return;
        }

        $data = json_decode(File::get($jsonPath), true);

        // 1. Seed Provinces
        if (isset($data['provinces'])) {
            foreach ($data['provinces'] as $prov) {
                Province::updateOrCreate(
                    ['id' => $prov['id']],
                    [
                        'name' => $prov['name'],
                        'tagline' => $prov['tagline'],
                        'description' => $prov['description'],
                        'image' => $prov['image'],
                        'sections' => $prov['sections'] ?? []
                    ]
                );
            }
        }

        // Keep track of tags to prevent multiple queries
        $tagCache = [];

        // 2. Seed Places and associated data
        if (isset($data['places'])) {
            foreach ($data['places'] as $item) {
                // Create/Update the main Place
                $place = Place::updateOrCreate(
                    ['id' => $item['id']],
                    [
                        'name' => $item['name'],
                        'province_id' => $item['province'],
                        'tagline' => $item['tagline'],
                        'image' => $item['image'],
                        'quick_info' => $item['quickInfo'] ?? [],
                        'about' => $item['about'] ?? '',
                        'about_image' => $item['aboutImage'] ?? null,
                        'map_link' => $item['mapLink'] ?? null
                    ]
                );

                // 3. Tags (Many-to-Many)
                $tagIds = [];
                if (isset($item['tags'])) {
                    foreach ($item['tags'] as $tagName) {
                        $tagNameClean = trim($tagName);
                        if (empty($tagNameClean)) continue;

                        if (!isset($tagCache[$tagNameClean])) {
                            $tag = Tag::firstOrCreate(['name' => $tagNameClean]);
                            $tagCache[$tagNameClean] = $tag->id;
                        }
                        $tagIds[] = $tagCache[$tagNameClean];
                    }
                }
                $place->tags()->sync($tagIds);

                // 4. Activities (thingsToDo)
                if (isset($item['thingsToDo'])) {
                    foreach ($item['thingsToDo'] as $actName) {
                        Activity::create([
                            'place_id' => $place->id,
                            'name' => $actName
                        ]);
                    }
                }

                // 5. Food
                if (isset($item['food'])) {
                    foreach ($item['food'] as $f) {
                        Food::create([
                            'place_id' => $place->id,
                            'name' => $f['name'],
                            'image' => $f['image'] ?? null,
                            'description' => $f['desc'] ?? ($f['description'] ?? null)
                        ]);
                    }
                }

                // 6. Hotels
                if (isset($item['hotels'])) {
                    foreach ($item['hotels'] as $h) {
                        Hotel::create([
                            'place_id' => $place->id,
                            'name' => $h['name'],
                            'image' => $h['image'] ?? null,
                            'description' => $h['desc'] ?? ($h['description'] ?? null),
                            'price' => $h['price'] ?? null,
                            'map_link' => $h['mapLink'] ?? ($h['map_link'] ?? null)
                        ]);
                    }
                }

                // 7. Restaurants
                if (isset($item['restaurants'])) {
                    foreach ($item['restaurants'] as $r) {
                        Restaurant::create([
                            'place_id' => $place->id,
                            'name' => $r['name'],
                            'image' => $r['image'] ?? null,
                            'description' => $r['desc'] ?? ($r['description'] ?? null),
                            'map_link' => $r['mapLink'] ?? ($r['map_link'] ?? null)
                        ]);
                    }
                }
            }
        }
    }
}
